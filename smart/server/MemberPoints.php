<?php
require_once('../lib/DataModel.php');
$params = array(
	'baseTable' => 'members',
	'pk_col' => 'memberID'
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
		$year = date('Y');
	}
	$argsIN['sql'] = "
	select
		M.memberID,
		st.statusType,
		REPLACE(CONCAT(M.firstName,' ',IFNULL(M.midName,''),' ',M.lastName),'  ',' ') as 'FullName',
		sum(dt.datePoints) as 'Points'
	from
		memberDates d
		inner join members M on M.memberID = d.memberID_fk
		inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
	    inner join statusTypes st on M.statusTypeID_fk = st.statusTypeID
	where
		M.memberID = coalesce(:id, M.memberID)
		and year(d.memberDate) = {$year}
	group by
		M.memberID,
		st.statusType,
		REPLACE(CONCAT(M.firstName,' ',IFNULL(M.midName,''),' ',M.lastName),'  ',' ')
	order by
		sum(dt.datePoints) desc,
		REPLACE(CONCAT(M.firstName,' ',IFNULL(M.midName,''),' ',M.lastName),'  ',' ');
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
