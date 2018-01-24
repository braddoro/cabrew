<?php
require_once('../../lib/DataModel.php');
$params = array(
	'baseTable' => 'library_loans',
	'pk_col' => 'loanID',
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
	if(isset($argsIN['loanID'])) {
		$loanID = ($argsIN['loanID'] > 0) ? $argsIN['loanID'] : NULL;
	}else{
		$loanID = 'NULL';
	}
	$argsIN['sql'] = "
	select
		ll.loanID,
		me.memberID,
		me.firstName,
		me.lastName,
		ll.requestDate,
		ll.loanDate,
		ll.returnDate,
		lb.title,
		ll.lastChangeDate
	from library_loans ll
		inner join members me on ll.memberID_fk = me.memberID
		inner join library_books lb on lb.bookID = ll.libraryID_fk
	where
		ll.loanID = coalesce(:id, ll.loanID)
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
