<?php
require_once('DataModel.php');
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
	$argsIN['sql'] = "
		select
			M.memberID,
			M.sex,
			M.lastName,
			M.firstName,
			M.statusTypeID_fk,
			M.lastChangeDate,
			C.memberContact as 'Email',
			C2.memberContact as 'Phone',
			REPLACE(CONCAT(M.firstName,  ' ', IFNULL(M.midName,''),  ' ', M.lastName),'  ',' ') as 'FullName',
			max(D.memberDate) as 'LastPayment',
			max(D2.memberDate) as 'JoinedDate',
			floor(datediff(now(), max(D.memberDate))/30.4) as 'MonthsPaid'
		from members M
			left join memberDates D on M.memberID = D.memberID_fk and D.dateTypeID_fk = 3
			left join memberDates D2 on M.memberID = D2.memberID_fk and D2.dateTypeID_fk = 1
			left join memberContacts C on M.memberID = C.memberID_fk and C.contactTypeID_fk = 2
			left join memberContacts C2 on M.memberID = C2.memberID_fk and C2.contactTypeID_fk = 1
		where
			M.memberID = coalesce(:id, M.memberID)
		group by
			M.memberID,
			M.sex,
			M.lastName,
			M.firstName,
			M.statusTypeID_fk,
			M.lastChangeDate,
			C.memberContact,
			C2.memberContact
		order by
			M.statusTypeID_fk,
			D.memberDate,
			M.lastName,
			M.firstName;";
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
