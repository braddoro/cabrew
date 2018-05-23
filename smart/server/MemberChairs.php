<?php
require_once('../../lib/DataModel_local.php');
$params = array(
	'baseTable' => 'memberChairs',
	'pk_col' => 'memberChairID',
	'allowedOperations' => array('fetch', 'add', 'update','remove'),
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
	if(isset($argsIN['memberID_fk'])) {
		$memberID_fk = ($argsIN['memberID_fk'] > 0) ? $argsIN['memberID_fk'] : null;
	}else{
		$memberID_fk = 'NULL';
	}
	if(isset($argsIN['dateTypeID_fk'])) {
		$dateTypeID_fk = ($argsIN['dateTypeID_fk'] > 0) ? $argsIN['dateTypeID_fk'] : null;
	}else{
		$dateTypeID_fk = 'NULL';
	}
	if(isset($argsIN['chairTypeID_fk'])) {
		$chairTypeID_fk = ($argsIN['chairTypeID_fk'] > 0) ? $argsIN['chairTypeID_fk'] : null;
	}else{
		$chairTypeID_fk = 'NULL';
	}
	$argsIN['sql'] = "select * from memberChairs where
		memberChairID = coalesce(:id, memberChairID)
		and memberID_fk = coalesce($memberID_fk, memberID_fk)
		and dateTypeID_fk = coalesce($dateTypeID_fk, dateTypeID_fk)
		and chairTypeID_fk = coalesce($chairTypeID_fk, chairTypeID_fk);";
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
