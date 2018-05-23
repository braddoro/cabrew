<?php
require_once('../../lib/DataModel_local.php');
$params = array(
	'baseTable' => 'memberDates',
	'pk_col' => 'memberDateID',
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
		$memberID_fk = ($argsIN['memberID_fk'] > 0) ? $argsIN['memberID_fk'] : NULL;
	}else{
		$memberID_fk = 'NULL';
	}
	if(isset($argsIN['dateTypeID_fk'])) {
		$dateTypeID_fk = ($argsIN['dateTypeID_fk'] > 0) ? $argsIN['dateTypeID_fk'] : NULL;
	}else{
		$dateTypeID_fk = 'NULL';
	}
	$argsIN['sql'] = "select * from memberDates where
		memberDateID = coalesce(:id, memberDateID)
		and memberID_fk = coalesce($memberID_fk, memberID_fk)
		and dateTypeID_fk = coalesce($dateTypeID_fk, dateTypeID_fk)";
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
