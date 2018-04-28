<?php
require_once('../../lib/DataModel.php');
$params = array(
	'baseTable' => 'memberContacts',
	'pk_col' => 'memberContactID',
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
		$memberID = ($argsIN['memberID_fk'] > 0) ? $argsIN['memberID_fk'] : 'null';
	}else{
		$memberID = 'null';
	}
	$argsIN['sql'] = "select * from memberContacts c where
		c.memberContactID = coalesce(:id, c.memberContactID)
		and c.memberID_fk = coalesce($memberID, c.memberID_fk);";
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
