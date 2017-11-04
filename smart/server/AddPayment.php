<?php
require_once('../../lib/DataModel.php');
$response = "";
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
// switch($operationType){
// case 'fetch':
// 	$memberID = (isset($argsIN['memberID'])) ? intval($argsIN['memberID']) : 0;
// 	$argsIN['sql'] = "
// 	select
// 		M.memberID,
// 		REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ') as 'FullName',
// 		M.renewalYear as 'Year',
// 		D.dateTypeID_fk
// 	from
// 		memberDates D
// 		inner join members M on M.memberID = D.memberID_fk
// 	where
// 		d.memberDateID = coalesce(:id, d.memberDateID)
// 		and m.memberID = coalesce($memberID,m.memberID)
// 	;";
// 	$response = $lclass->pdoFetch($argsIN);
// 	break;
// case 'add':
// 	$memberID = (isset($argsIN['memberID'])) ? intval($argsIN['memberID']) : 0;
// 	$resetMonth = (isset($argsIN['resetMonth'])) ? intval($argsIN['resetMonth']) : 0;
// 	$renewalDate = (isset($argsIN['renewalDate'])) ? $argsIN['renewalDate'] : NULL;
// 	$note = (isset($argsIN['note'])) ? $argsIN['note'] : NULL;
// 	$argsIN['procedure'] = "addMemberPayment({$memberID},'{$renewalDate}',{$resetMonth},'{$note}')";
// 	$response = $lclass->pdoProc($argsIN);
// 	break;
// case 'update':
// 	$response = $lclass->pdoUpdate($argsIN);
// 	break;
// case 'remove':
// 	$response = $lclass->pdoRemove($argsIN);
// 	break;
// default:
// 	$response = array('status' => 0);
// 	break;
// }
echo json_encode($response);
?>
