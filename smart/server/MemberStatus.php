<?php
require_once('../../lib/DataModel.php');
$params = array(
	'baseTable' => 'members',
	'pk_col' => 'memberID',
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
	if(isset($argsIN['statusTypeID_fk'])) {
		$statusTypeID = ($argsIN['statusTypeID_fk'] > 0) ? $argsIN['statusTypeID_fk'] : NULL;
	}else{
		$statusTypeID = 'NULL';
	}
	if(isset($argsIN['renewalYear'])) {
		$renewalYear = ($argsIN['renewalYear'] > 0) ? $argsIN['renewalYear'] : NULL;
	}else{
		$renewalYear = 'NULL';
	}
	if(isset($argsIN['FullName'])) {
		$fullName = ($argsIN['FullName'] > '') ? $argsIN['FullName'] : NULL;
	}else{
		$fullName = 'NULL';
	}

// M.statusTypeID_fk)
// group by
// M.memberID,
// M.sex,
// M.firstName,
//
	$argsIN['sql'] = "
		select
			M.memberID,
			M.sex,
			M.firstName,
			M.lastName,
			M.statusTypeID_fk,
			M.renewalYear,
			M.lastChangeDate,
			ST.statusType as 'Status',
			TIMESTAMPDIFF(MONTH, max(D2.memberDate), now()) as 'Ratio',
			REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ') as 'FullName',
			max(D.memberDate) as 'LastPayment',
			max(D2.memberDate) as 'JoinedDate',
			count(D3.memberDate) as 'Meetings',
			floor(datediff(now(), max(D.memberDate))/30.4) as 'MonthsPaid'
		from members M
			inner join statusTypes ST on M.statusTypeID_fk = ST.statusTypeID
			left join memberDates D on M.memberID = D.memberID_fk and D.dateTypeID_fk = 3
			left join memberDates D2 on M.memberID = D2.memberID_fk and D2.dateTypeID_fk = 1
			left join memberDates D3 on M.memberID = D3.memberID_fk and D3.dateTypeID_fk = 6
		where
			M.memberID = coalesce(:id, M.memberID)
			and M.statusTypeID_fk = coalesce({$statusTypeID},M.statusTypeID_fk)
			and M.renewalYear = coalesce({$renewalYear}, M.renewalYear)
			and REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ') = coalesce({$fullName}, REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' '))
		group by
			M.memberID,
			M.sex,
			M.firstName,
			M.lastName,
			M.statusTypeID_fk,
			M.renewalYear,
			M.lastChangeDate,
			ST.statusType
		order by
			M.statusTypeID_fk,
			M.firstName,
			M.lastName,
			D.memberDate;";
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
