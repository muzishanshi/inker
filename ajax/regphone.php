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

if(empty($themeOptions["switch"]) || !in_array('isPhoneLogin', $themeOptions["switch"])){
	$json=json_encode(array("error_code"=>-2,"message"=>"未开启手机号登陆"));
	echo $json;
	exit;
}
if(!preg_match("/^1[34578]\d{9}$/", $cnphone)){
	$json=json_encode(array("error_code"=>-4,"message"=>"请输入正确的手机号"));
	echo $json;
	exit;
}
if(empty($themeOptions["switch"])||(!empty($themeOptions["switch"]) && in_array('isShowImgCode', $themeOptions["switch"]))){
	if(strcasecmp($_SESSION['code'],$imgcode)!=0){
		$json=json_encode(array("error_code"=>-7,"message"=>"图文验证码错误"));
		echo $json;
		exit;
	}
}
if(empty($themeOptions["switch"])||(!empty($themeOptions["switch"]) && in_array('isShowSmsCode', $themeOptions["switch"]))){
	if(!isset($_SESSION['phonecode'])||strcasecmp($_SESSION['phonecode'],$code)!=0){
		$json=json_encode(array("error_code"=>-1,"message"=>"手机验证码错误"));
		echo $json;
		exit;
	}
	if (isset($_SESSION["newphone"])&&$cnphone!=$_SESSION["newphone"]) {
		$json=json_encode(array("error_code"=>-8,"message"=>"填写手机号和发送验证码的手机号不一致"));
		echo $json;
		exit;
	}
}
$config=$db->getConfig();
alterColumn($db,$config[0]->database,$db->getPrefix().'users','phone','varchar(16) DEFAULT NULL');

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
	$query= $db->select()->from('table.users')->orWhere('phone = ?', $cnphone); 
	$user = $db->fetchRow($query);
	if($user){
		$json=json_encode(array("error_code"=>-9,"message"=>"登陆失败，该手机号已被绑定。"));
		echo $json;
		exit;
	}
	$hasher = new PasswordHash(8, true);

	$screenName= substr_replace($cnphone,'****',3,4);
	$mail=time().'@'.$_SERVER['SERVER_NAME'];
	$dataStruct = array(
		'name'      =>  $cnphone,
		'mail'      =>  $mail,
		'screenName'=>  $screenName,
		'password'  =>  $hasher->HashPassword($pwd),
		'created'   =>  time(),
		'group'     =>  'subscriber',
		'phone'     =>  $cnphone
	);
	
	$insert = $db->insert('table.users')->rows($dataStruct);
	$insertId = $db->query($insert);
	
	$host = 'https://secure.gravatar.com';
	$url = '/avatar/';
	$size = '50';
	$rating = 'g';
	$hash = md5(strtolower($mail));
	$avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=mm';
	
	$INKERUSERINFO=json_encode(array("name"=>$screenName,"pic"=>$avatar));
	setcookie('INKERUSERINFO', $INKERUSERINFO,0);
	
	$json=json_encode(array("error_code"=>0,"message"=>"注册中","data"=>array("INKERUSERINFO"=>$INKERUSERINFO)));
	echo $json;
}
/*重置短信验证码*/
$_SESSION['phonecode'] = mt_rand(100000,999999);

/*修改数据表字段*/
function alterColumn($db,$dbname,$table,$column,$define){
	$prefix = $db->getPrefix();
	$query= "select * from information_schema.columns WHERE TABLE_SCHEMA='".$dbname."' and table_name = '".$table."' AND column_name = '".$column."'";
	$row = $db->fetchRow($query);
	if(count($row)==0){
		$db->query('ALTER TABLE `'.$table.'` ADD COLUMN `'.$column.'` '.$define.';');
	}
}
?>