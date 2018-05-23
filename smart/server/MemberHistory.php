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
	if(isset($argsIN['YearDate'])) {
		$yearDate = 'YEAR(' .$argsIN['YearDate'] . ')';
	}else{
		$yearDate = 'NULL';
	}
	$argsIN['sql'] = "select md.*, year(md.memberdate) as 'YearDate'
	from memberDates md
 	where md.memberDateID = coalesce(:id, md.memberDateID)
 	and YEAR(md.memberDate) = coalesce({$yearDate}, YEAR(md.memberDate))
	order by md.memberdate desc";
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
