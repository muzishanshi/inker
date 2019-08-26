<?php 
namespace Aliyun\DySDKLite\Sms;
session_start();
date_default_timezone_set('Asia/Shanghai');
include '../../../../config.inc.php';
require_once "../libs/SignatureHelper.php";
require_once("../libs/themeOptions.php");
use Aliyun\DySDKLite\SignatureHelper;
use themeOptions;
use smtp;
use Typecho_Db;
use PHPMailer;
$theme = new themeOptions;
$themeOptions=$theme->getThemeOptions();

$action = isset($_GET['action']) ? addslashes(trim($_GET['action'])) : '';
$cnphone = isset($_GET['cnphone']) ? addslashes(trim($_GET['cnphone'])) : '';
$captcha = isset($_GET['captcha']) ? addslashes(trim($_GET['captcha'])) : '';

if(strcasecmp($_SESSION['code'],$captcha)!=0){
	$json=json_encode(array("error_code"=>-1,"message"=>"图文验证码错误"));
	echo $json;
	exit;
}

switch($action){
	case "phone":
		$_SESSION[$action.'code'] = mt_rand(100000,999999);
		if(empty($themeOptions["switch"]) || !in_array('isPhoneLogin', $themeOptions["switch"])){
			$json=json_encode(array("error_code"=>-3,"message"=>"未开启手机号登陆"));
			echo $json;
			exit;
		}
		$result=sendPhoneSms($themeOptions["aliyun_accessKeyId"],$themeOptions["aliyun_accessKeySecret"],$themeOptions["aliyun_templatecode"],$themeOptions["aliyun_signname"],$cnphone,$_SESSION[$action.'code']);
		if($result->Code=="OK"){
			$_SESSION['new'.$action] = $cnphone;
			$json=json_encode(array("error_code"=>0,"message"=>"发送验证码成功"));
			echo $json;
		}else{
			$json=json_encode(array("error_code"=>-2,"message"=>"发送验证码失败"));
			echo $json;
		}
		break;
	case "mail":
		$_SESSION[$action.'code'] = mt_rand(100000,999999);
		if(empty($themeOptions["switch"]) || !in_array('isMailLogin', $themeOptions["switch"])){
			$json=json_encode(array("error_code"=>-3,"message"=>"未开启邮箱登陆"));
			echo $json;
			exit;
		}
		$db = Typecho_Db::get();
		$queryTitle= $db->select('value')->from('table.options')->where('name = ?', 'title'); 
		$rowTitle = $db->fetchRow($queryTitle);
		$result=sendMailSms($themeOptions["mailsmtp"],$themeOptions["mailport"],$themeOptions["mailuser"],$themeOptions["mailpass"],$themeOptions["mailsecure"],$cnphone,'【'.$rowTitle["value"].'】验证码','欢迎使用'.$rowTitle["value"].'验证码服务，您的验证码是：'.$_SESSION[$action.'code']);
		if($result){
			$_SESSION['new'.$action] = $cnphone;
			$json=json_encode(array("error_code"=>0,"message"=>"发送验证码成功"));
			echo $json;
		}else{
			$json=json_encode(array("error_code"=>-2,"message"=>"发送验证码失败"));
			echo $json;
		}
		break;
}
exit;
/*发送邮件*/
function sendMailSms($mailsmtp,$mailport,$mailuser,$mailpass,$mailsecure,$email,$title,$content){
	require_once dirname(__FILE__).'/../libs/PHPMailer/PHPMailerAutoload.php';
	$phpMailer = new PHPMailer();
	$phpMailer->isSMTP();
	$phpMailer->SMTPAuth = true;
	$phpMailer->Host = $mailsmtp;
	$phpMailer->Port = $mailport;
	$phpMailer->Username = $mailuser;
	$phpMailer->Password = $mailpass;
	$phpMailer->isHTML(true);
	if ('none' != $mailsecure) {
		$phpMailer->SMTPSecure = $mailsecure;
	}
	$phpMailer->setFrom($mailuser, $title);
	$phpMailer->addAddress($email, $email);
	$phpMailer->Subject = $title;
	$phpMailer->Body    = $content;
	if(!$phpMailer->send()) {
		return false;
	} else {
		return true;
	}
}
/**
 * 发送短信
 */
function sendPhoneSms($accessKeyId,$accessKeySecret,$templatecode,$signname,$phone,$code) {
    $params = array ();
    // *** 需用户填写部分 ***
    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
    // fixme 必填: 短信接收号码
    $params["PhoneNumbers"] = $phone;
    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    $params["SignName"] = $signname;
    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    $params["TemplateCode"] = $templatecode;
    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
    $params['TemplateParam'] = Array (
		"code" => $code
	);
    // fixme 可选: 设置发送短信流水号
    $params['OutId'] = "";
    // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
    $params['SmsUpExtendCode'] = "";
    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }
    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new SignatureHelper();
    // 此处可能会抛出异常，注意catch
    $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
        // fixme 选填: 启用https
        ,true
    );
    return $content;
}
?>