<?php
require_once('../../lib/DataModel.php');
$params = array(
	'baseTable' => 'library',
	'pk_col' => 'libraryID',
	'allowedOperations' => array('fetch', 'add', 'update', 'delete'),
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
	if(isset($argsIN['libraryID'])) {
		$libraryID = ($argsIN['libraryID'] > 0) ? $argsIN['libraryID'] : NULL;
	}else{
		$libraryID = 'NULL';
	}
	// if(isset($argsIN['Year'])) {
	// 	$year = ($argsIN['Year'] > 0) ? $argsIN['Year'] : NULL;
	// }else{
	// 	$year = 'NULL';
	// }
	$argsIN['sql'] = "
	select
		l.libraryID, l.series, l.title, l.author, l.copyright, l.abstract
	from
		library l
	where
		l.libraryID = coalesce(:id, l.libraryID)
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
