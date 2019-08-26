<?php 
header('Access-Control-Allow-Credentials:true');
session_start();
date_default_timezone_set('Asia/Shanghai');
include '../../../../config.inc.php';
require_once("../libs/themeOptions.php");
$db = Typecho_Db::get();
$theme = new themeOptions;
$themeOptions=$theme->getThemeOptions();

$cnphone = isset($_GET['cnphone']) ? addslashes(trim($_GET['cnphone'])) : '';
$pwd = isset($_GET['pwd']) ? addslashes(trim($_GET['pwd'])) : '';
$imgcode = isset($_GET['imgcode']) ? addslashes(trim($_GET['imgcode'])) : '';
$code = isset($_GET['code']) ? addslashes(trim($_GET['code'])) : '';

if(empty($themeOptions["switch"]) || !in_array('isMailLogin', $themeOptions["switch"])){
	$json=json_encode(array("error_code"=>-2,"message"=>"未开启邮箱登陆"));
	echo $json;
	exit;
}
if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$cnphone)){
	$json=json_encode(array("error_code"=>-4,"message"=>"请输入正确的邮箱"));
	echo $json;
	exit;
}
if(empty($themeOptions["switch"])||(!empty($themeOptions["switch"]) && in_array('isShowImgCode', $themeOptions["switch"]))){
	if(isset($_SESSION['code'])&&strcasecmp($_SESSION['code'],$imgcode)!=0){
		$json=json_encode(array("error_code"=>-7,"message"=>"图文验证码错误"));
		echo $json;
		exit;
	}
}
if(empty($themeOptions["switch"])||(!empty($themeOptions["switch"]) && in_array('isShowSmsCode', $themeOptions["switch"]))){
	if(isset($_SESSION['mailcode'])&&strcasecmp($_SESSION['mailcode'],$code)!=0){
		$json=json_encode(array("error_code"=>-1,"message"=>"邮箱验证码错误"));
		echo $json;
		exit;
	}
	if (isset($_SESSION["newmail"])&&$cnphone!=$_SESSION["newmail"]) {
		$json=json_encode(array("error_code"=>-8,"message"=>"填写邮箱和发送验证码的邮箱不一致"));
		echo $json;
		exit;
	}
}
$query= $db->select()->from('table.users')->where('name = ?', $cnphone); 
$user = $db->fetchRow($query);
if($user){
	/*登录*/
	$login=Typecho_Widget::widget('Widget_User');
	if(!$login->login($user["name"],$pwd)){
		$json=json_encode(array("error_code"=>-6,"message"=>"登陆失败，请检查密码是否正确"));
		echo $json;
		exit;
	}
	
	$nick=$user['screenName']!=""?$user['screenName']:$user['name'];
	
	$host = 'https://secure.gravatar.com';
	$url = '/avatar/';
	$size = '50';
	$rating = 'g';
	$hash = md5(strtolower($user["mail"]));
	$avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=mm';
	
	$INKERUSERINFO=json_encode(array("name"=>$nick,"pic"=>$avatar));
	setcookie('INKERUSERINFO', $INKERUSERINFO,0);
	
	$json=json_encode(array("error_code"=>0,"message"=>"登陆中","data"=>array("INKERUSERINFO"=>$INKERUSERINFO)));
	echo $json;
}else{
	if (!Typecho_Widget::widget('Widget_Options')->allowRegister) {
		$json=json_encode(array("error_code"=>-3,"message"=>"不允许注册"));
		echo $json;
		exit;
	}
	if(strlen($pwd)<6){
		$json=json_encode(array("error_code"=>-5,"message"=>"请输入长度不小于6位的密码"));
		echo $json;
		exit;
	}
	$query= $db->select()->from('table.users')->orWhere('mail = ?', $cnphone); 
	$user = $db->fetchRow($query);
	if($user){
		$json=json_encode(array("error_code"=>-6,"message"=>"登陆失败，该邮箱已被绑定。"));
		echo $json;
		exit;
	}
	$hasher = new PasswordHash(8, true);

	$dataStruct = array(
		'name'      =>  $cnphone,
		'mail'      =>  $cnphone,
		'screenName'=>  $cnphone,
		'password'  =>  $hasher->HashPassword($pwd),
		'created'   =>  time(),
		'group'     =>  'subscriber'
	);
	
	$insert = $db->insert('table.users')->rows($dataStruct);
	$insertId = $db->query($insert);
	
	$host = 'https://secure.gravatar.com';
	$url = '/avatar/';
	$size = '50';
	$rating = 'g';
	$hash = md5(strtolower($cnphone));
	$avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=mm';
	
	$INKERUSERINFO=json_encode(array("name"=>$cnphone,"pic"=>$avatar));
	setcookie('INKERUSERINFO', $INKERUSERINFO,0);
	
	$json=json_encode(array("error_code"=>0,"message"=>"注册中","data"=>array("INKERUSERINFO"=>$INKERUSERINFO)));
	echo $json;
}
/*重置短信验证码*/
$_SESSION['mailcode'] = mt_rand(100000,999999);
?>