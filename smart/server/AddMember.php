<?php
require_once('../../lib/DataModel.php');
$params = array(
	'baseTable' => 'memberDates',
	'pk_col' => 'memberDateID',
	'allowedOperations' => array('fetch','add'),
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
		m.memberID,
		REPLACE(CONCAT(IFNULL(m.firstName,m.nickName), ' ', m.lastName),'  ',' ') as 'FullName',
		dt.dateTypeID,
		dt.datePoints,
		year(d.memberDate) as 'Year',
		d.memberDate,
		d.dateDetail,
		m.sex,
		m.lastName,
		m.firstName,
		m.statusTypeID_fk
	from
		memberDates d
		inner join members m on m.memberID = d.memberID_fk
		inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
	where
		d.memberDateID = coalesce(:id, d.memberDateID)
		and dt.datePoints > $points
		and year(d.memberDate) = coalesce($year,year(d.memberDate))
		and m.memberID = coalesce($memberID,m.memberID)
		and dt.dateTypeID = coalesce($dateTypeID,dt.dateTypeID)
	order by
		d.memberDate,
		dt.dateType;
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
