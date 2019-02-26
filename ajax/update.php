<?php
include '../../../../config.inc.php';
require_once("../libs/ZipFolder.php");

$action = isset($_POST['action']) ? addslashes(trim($_POST['action'])) : '';
if($action=="download"){
	$version = isset($_POST['version']) ? addslashes(trim($_POST['version'])) : '';
	$version=file_get_contents('https://www.tongleer.com/api/interface/inker.php?action=update&version='.$version);
	echo $version;
	exit;
}else if($action=="update"){
	$url = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
	$filename= substr( $url , strrpos($url , '/')+1 );
	$zip = new ZipFolder;
	$arr=$zip->getFile($url,__TYPECHO_ROOT_DIR__.__TYPECHO_THEME_DIR__."/",$filename,1);
	
	if($arr){
		$result=$zip->unzip(__TYPECHO_ROOT_DIR__.__TYPECHO_THEME_DIR__."/".$filename,__TYPECHO_ROOT_DIR__.__TYPECHO_THEME_DIR__);
		if($result){
			$json=json_encode(array("code"=>"ok","message"=>"更新完成"));
			echo $json;
		}else{
			$json=json_encode(array("code"=>"fail","message"=>"更新未完成"));
			echo $json;
		}
		@unlink(__TYPECHO_ROOT_DIR__.__TYPECHO_THEME_DIR__."/".$filename);
	}else{
		$json=json_encode(array("code"=>"download error","message"=>"下载更新包失败"));
		echo $json;
	}
	exit;
}
?>