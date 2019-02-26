<?php
include '../../../../config.inc.php';
require_once("../libs/ZipFolder.php");

$unzipdir=__TYPECHO_ROOT_DIR__;
$zipfile=dirname(__FILE__)."/../libs/m.zip";
if(is_dir($unzipdir."/m/")){
	$json=json_encode(array("status"=>"fail","msg"=>"手机版目录已存在于网站根目录"));
	echo $json;
	exit;
}
if(!is_writable($unzipdir)){
	$json=json_encode(array("status"=>"fail","msg"=>"网站根目录不可写，请更改目录权限。"));
	echo $json;
	exit;
}
$zip = new ZipFolder;
$result=$zip->unzip($zipfile,$unzipdir);
if($result){
	$json=json_encode(array("status"=>"ok","msg"=>"安装成功"));
	echo $json;
	exit;
}else{
	$json=json_encode(array("status"=>"ok","msg"=>"安装失败"));
	echo $json;
	exit;
}
?>