
<?php
require_once('../../lib/DataModel.php');
$params = array(
	'baseTable' => 'brew_clubs',
	'pk_col' => 'clubID',
	'allowedOperations' => array('fetch'),
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
	// if(isset($argsIN['statusTypeID_fk'])) {
	// 	$statusTypeID = ($argsIN['statusTypeID_fk'] > 0) ? $argsIN['statusTypeID_fk'] : NULL;
	// }else{
	// 	$statusTypeID = 'NULL';
	// }
	// if(isset($argsIN['renewalYear'])) {
	// 	$renewalYear = ($argsIN['renewalYear'] > 0) ? $argsIN['renewalYear'] : NULL;
	// }else{
	// 	$renewalYear = 'NULL';
	// }
	// if(isset($argsIN['firstName'])) {
	// 	$firstName = ($argsIN['firstName'] > '') ? "LOWER('%" .$argsIN['firstName'] . "%')" : NULL;
	// }else{
	// 	$firstName = 'NULL';
	// }
	// if(isset($argsIN['lastName'])) {
	// 	$lastName = ($argsIN['lastName'] > '') ? "LOWER('%" .$argsIN['lastName'] . "%')" : NULL;
	// }else{
	// 	$lastName = 'NULL';
	// }
	// if(isset($argsIN['FullName'])) {
	// 	$fullName = ($argsIN['FullName'] > '') ? "LOWER('%" .$argsIN['FullName'] . "%')" : NULL;
	// }else{
	// 	$fullName = 'NULL';
	// }

	// M.memberID = coalesce(:id, M.memberID)
	// and M.statusTypeID_fk = coalesce({$statusTypeID},M.statusTypeID_fk)
	// and M.renewalYear = coalesce({$renewalYear}, M.renewalYear)
	// and LOWER(M.firstName) like coalesce({$firstName}, M.firstName)
	// and LOWER(M.lastName) like coalesce({$lastName}, M.lastName)
	// and LOWER(REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ',IFNULL(M.midName,''), ' ', M.lastName),'  ',' ')) like coalesce({$fullName}, REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ',IFNULL(M.midName,''), ' ', M.lastName),'  ',' '))

	$argsIN['sql'] = "
select
c.clubID,
bc.contactID,
cp.contactPointID,
bm.mediaID,
c.clubName,
c.clubAbbr,
concat(c.city,', ',c.state) 'Location',
bc.contactName,
bc.priority,
cp.contactPoint,
ct1.contactType as 'cp_contactType',
cp.priority,
bm.media,
ct2.contactType as 'bm_contactType',
bm.priority
from brew_clubs c
left join brew_contacts bc on c.clubID = bc.clubID
left join brew_contactPoints cp on bc.contactID = cp.contactID
left join brew_media bm on c.clubID = bm.clubID
left join contactTypes ct1 on cp.contactTypeID_fk = ct1.contactTypeID
left join contactTypes ct2 on bm.contactTypeID_fk = ct2.contactTypeID
where
	c.clubID = coalesce(:id, c.clubID)

order by c.clubName, bc.contactName, cp.contactPoint;
";
// and M.statusTypeID_fk = coalesce({$statusTypeID},M.statusTypeID_fk)
	//echo "/* {$argsIN['sql']} */";
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
