<?php
require_once('../../lib/DataModel.php');
$params = array(
	'baseTable' => 'library_books',
	'pk_col' => 'bookID',
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
	if(isset($argsIN['bookID'])) {
		$bookID = ($argsIN['bookID'] > 0) ? $argsIN['bookID'] : NULL;
	}else{
		$bookID = 'NULL';
	}
	$argsIN['sql'] = "select l.bookID, l.series, l.title, l.author, l.copyright, l.abstract from library_books l where l.bookID = coalesce(:id, l.bookID)";
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
