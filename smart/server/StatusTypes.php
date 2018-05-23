<?php
require_once('../../lib/DataModel_local.php');
$params = array(
	'baseTable' => 'statusTypes',
	'pk_col' => 'statusTypeID',
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
	if(isset($argsIN['active'])) {
		$active = ($argsIN['active'] > '') ? "'" . $argsIN['active'] . "'" : "'Y'";
	}else{
		$active = 'null';
	}
	$argsIN['sql'] = "select * from statusTypes st where st.statusTypeID = coalesce(:id, st.statusTypeID) and st.active = coalesce({$active}, st.active);";
	 // echo "/* {$argsIN['sql']} */";
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
