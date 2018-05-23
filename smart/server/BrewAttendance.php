<?php
require_once('../../lib/DataModel_local.php');
$params = array(
	'baseTable' => 'brew_attendence',
	'pk_col' => 'attendenceID',
	'allowedOperations' => array('fetch', 'add', 'update', 'remove'),
	'ini_file' => realpath('../../lib/server.ini')
);
$lclass = New DataModel();
$lclass->init($params);
if($lclass->status != 0){
	$response = array('status' => $lclass->status, 'errorMessage' => $lclass->errorMessage);
	echo json_encode($response);
	exit;
}
$argsIN = array_merge($_POST,$_GET);
$operationType = (isset($argsIN['operationType'])) ? $argsIN['operationType'] : null;
switch($operationType){
case 'fetch':
	if(isset($argsIN['clubID'])) {
		$clubID = ($argsIN['clubID'] > 0) ? $argsIN['clubID'] : NULL;
	}else{
		$clubID = 'NULL';
	}
	$argsIN['sql'] = "select * from brew_attendence where
	attendenceID = coalesce(:id, attendenceID)
	and clubID = coalesce($clubID, clubID);";
	$response = $lclass->pdoFetch($argsIN);
	break;
case 'add':
	$response = $lclass->pdoAdd($argsIN);
	break;
case 'update':
	$response = $lclass->pdoUpdate($argsIN);
	break;
case 'remove':
	$response = $lclass->pdoRemove($argsIN);
	break;
default:
	$response = array('status' => 0);
	break;
}
echo json_encode($response);
?>
