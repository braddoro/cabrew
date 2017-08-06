<?php
require_once('../../lib/DataModel.php');
$params = array(
	'baseTable' => 'memberDates',
	'pk_col' => 'memberDateID'
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
	if(isset($argsIN['memberID'])) {
		$memberID = ($argsIN['memberID'] > 0) ? $argsIN['memberID'] : NULL;
	}else{
		$memberID = 'NULL';
	}
	if(isset($argsIN['year'])) {
		$year = ($argsIN['year'] > 0) ? $argsIN['year'] : NULL;
	}else{
		$year = 'NULL';
	}
	$argsIN['sql'] = "
	select
		m.memberID,
		d.memberDate,
		dt.dateTypeID,
		dt.datePoints,
		d.dateDetail,
		day(d.memberDate) as 'Day',
		month(d.memberDate) as 'Month',
		year(d.memberDate) as 'Year'

	from
		memberDates d
		inner join members m on m.memberID = d.memberID_fk
		inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
	where
		d.memberDateID = coalesce(:id, d.memberDateID)
		and dt.datePoints > 0
		and m.memberID = {$memberID}
		and year(d.memberDate) = {$year}
	order by
		d.memberDate,
		dt.dateType;
	";
	// echo("/*" . $argsIN['sql'] . "*/");
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
$response = str_replace("'", '`', $response);
$response = str_replace('"', '`', $response);
echo json_encode($response);
?>
