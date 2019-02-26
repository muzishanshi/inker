<?php
include '../../../../config.inc.php';
$db = Typecho_Db::get();
$prefix=$db->getPrefix();

$delete = $db->delete('table.fields')->where('str_value = ?', "")->where('int_value = ?', 0)->where('int_value = ?', 0);
$deletedRows = $db->query($delete);

$queryFields= "SELECT * FROM ".$prefix."fields";
$rowFields = $db->fetchAll($queryFields);
foreach($rowFields as $value){
	$query= "SELECT * FROM ".$prefix."contents WHERE cid=".$value["cid"];
	$row = $db->fetchRow($query);
	if(count($row)==0){
		$delete = $db->delete('table.fields')->where('cid = ?', $value["cid"]);
		$deletedRows = $db->query($delete);
	}
}

$json=json_encode(array("status"=>"ok","msg"=>"清理完成"));
echo $json;
exit;
?>