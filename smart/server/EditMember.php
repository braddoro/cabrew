<?php
require_once('../lib/DataModel.php');
$params = array(
	'baseTable' => 'members',
	'pk_col' => 'memberID',
	'allowedOperations' => array('fetch','edit','update')
);
$lclass = New DataModel($params);
if($lclass->status != 0){
	$response = array('status' => $lclass->status, 'errorMessage' => $lclass->errorMessage);
	echo json_encode($response);
	exit;
}
$argsIN = array_merge($_POST,$_GET);
$operationType = (isset($argsIN['operationType'])) ? $argsIN['operationType'] : null;
switch($operationType){
case 'fetch':
	if(isset($argsIN['Year'])) {
		$year = ($argsIN['Year'] > 0) ? $argsIN['Year'] : NULL;
	}else{
		$year = 'NULL';
	}
	if(isset($argsIN['memberID'])) {
		$memberID = ($argsIN['memberID'] > 0) ? $argsIN['memberID'] : NULL;
	}else{
		$memberID = 'NULL';
	}
	if(isset($argsIN['dateTypeID'])) {
		$dateTypeID = ($argsIN['dateTypeID'] > 0) ? $argsIN['dateTypeID'] : NULL;
	}else{
		$dateTypeID = 'NULL';
	}
	if(isset($argsIN['$points'])) {
		$points = ($argsIN['$points'] > 0) ? $argsIN['$points'] : NULL;
	}else{
		$points = '-1';
	}
	$argsIN['sql'] = "
	select
		*
	from
		members
	where
		memberID = coalesce(:id, memberID)
	order by
		firstName,
		lastName;
	";
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
