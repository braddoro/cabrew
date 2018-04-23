
<?php
require_once('../../lib/DataModel.php');
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
// 	if(isset($argsIN['statusTypeID_fk'])) {
// 		$statusTypeID = ($argsIN['statusTypeID_fk'] > 0) ? $argsIN['statusTypeID_fk'] : NULL;
// 	}else{
// 		$statusTypeID = 'NULL';
// 	}
// 	if(isset($argsIN['renewalYear'])) {
// 		$renewalYear = ($argsIN['renewalYear'] > 0) ? $argsIN['renewalYear'] : NULL;
// 	}else{
// 		$renewalYear = 'NULL';
// 	}
// 	if(isset($argsIN['firstName'])) {
// 		$firstName = ($argsIN['firstName'] > '') ? "LOWER('%" .$argsIN['firstName'] . "%')" : NULL;
// 	}else{
// 		$firstName = 'NULL';
// 	}
// 	if(isset($argsIN['lastName'])) {
// 		$lastName = ($argsIN['lastName'] > '') ? "LOWER('%" .$argsIN['lastName'] . "%')" : NULL;
// 	}else{
// 		$lastName = 'NULL';
// 	}
// 	if(isset($argsIN['FullName'])) {
// 		$fullName = ($argsIN['FullName'] > '') ? "LOWER('%" .$argsIN['FullName'] . "%')" : NULL;
// 	}else{
// 		$fullName = 'NULL';
// 	}
// 	$argsIN['sql'] = "
// select
// 	M.memberID,
// 	M.statusTypeID_fk,
// 	REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ',IFNULL(M.midName,''), ' ', M.lastName),'  ',' ') as 'FullName',
// 	M.firstName,
// 	M.midName,
// 	M.lastName,
// 	M.nickname,
// 	M.sex,
// 	M.renewalYear,
// 	M.lastChangeDate,
// 	MIN(D1.memberDate) as 'JoinedDate'
// from members M
// 	left join memberDates D1 on M.memberID = D1.memberID_fk and D1.dateTypeID_fk = 1
// where
// 	M.memberID = coalesce(:id, M.memberID)
// 	and M.statusTypeID_fk = coalesce({$statusTypeID},M.statusTypeID_fk)
// 	and M.renewalYear = coalesce({$renewalYear}, M.renewalYear)
// 	and LOWER(M.firstName) like coalesce({$firstName}, M.firstName)
// 	and LOWER(M.lastName) like coalesce({$lastName}, M.lastName)
// 	and LOWER(REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ',IFNULL(M.midName,''), ' ', M.lastName),'  ',' ')) like coalesce({$fullName}, REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ',IFNULL(M.midName,''), ' ', M.lastName),'  ',' '))
// group by
// 	M.memberID,
// 	M.statusTypeID_fk,
// 	M.firstName,
// 	M.midName,
// 	M.lastName,
// 	M.nickname,
// 	M.sex,
// 	M.renewalYear,
// 	M.lastChangeDate;";
// 	//echo "/* {$argsIN['sql']} */";
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
