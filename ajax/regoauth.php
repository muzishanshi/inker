<?php 
header('Access-Control-Allow-Credentials:true');
session_start();
date_default_timezone_set('Asia/Shanghai');
include '../../../../config.inc.php';
require_once("../libs/themeOptions.php");
$db = Typecho_Db::get();
$theme = new themeOptions;
$themeOptions=$theme->getThemeOptions();

$qq_url = '';
$wb_url='';
if(!empty($themeOptions["switch"]) && in_array('isQQLogin', $themeOptions["switch"])){
	$configdir=dirname(__FILE__).'/../config/';
	if(!is_dir($configdir)){
		mkdir ($configdir, 0777, true );
	}
	$qqstate=md5(uniqid(rand(), TRUE));
	file_put_contents($configdir.'config_oauth_qq.php','<?php die; ?>'.serialize(array(
		'qq_appid'=>$themeOptions['qq_appid'],
		'qq_appkey'=>$themeOptions['qq_appkey'],
		'qq_callback'=>$themeOptions['qq_callback'],
		'qqstate'=>$qqstate
	)));
	$qq_url = 'https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id='.$themeOptions['qq_appid'].'&redirect_uri='.urlencode($themeOptions['qq_callback']).'&state='.$qqstate;
}
if(!empty($themeOptions["switch"]) && in_array('isWeiboLogin', $themeOptions["switch"])){
	include_once( '../libs/saetv2.ex.class.php' );
	$o = new SaeTOAuthV2( $themeOptions['wb_akey'] , $themeOptions['wb_skey'] );
	$wb_url = $o->getAuthorizeURL( $themeOptions['wb_callback_url'] );
}
createTableOAuthLogin($db);
$json=json_encode(array("error_code"=>0,"msg"=>"获取第三方登陆url","data"=>array("qq_url"=>$qq_url,"wb_url"=>$wb_url)));
echo $json;

/*创建第三方登录缩短所用数据表*/
function createTableOAuthLogin($db){
	$prefix = $db->getPrefix();
	$db->query('CREATE TABLE IF NOT EXISTS '.$prefix.'multi_oauthlogin(
		`oauthid` varchar(64) COLLATE utf8_general_ci NOT NULL,
		`oauthuid` bigint(20) COLLATE utf8_general_ci NOT NULL,
		`oauthnickname` varchar(64) COLLATE utf8_general_ci DEFAULT NULL,
		`oauthfigureurl` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
		`oauthgender` varchar(8) COLLATE utf8_general_ci DEFAULT NULL,
		`oauthtype` enum("qq","weibo","weixin") COLLATE utf8_general_ci DEFAULT NULL,
		PRIMARY KEY (`oauthid`)
	) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
}
?>