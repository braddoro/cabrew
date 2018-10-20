<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$wheres = '';
// if(isset($_REQUEST['statusTypeID_fk'])){
// 	$wheres .= ' and M.statusTypeID_fk = ' . intval($_REQUEST['statusTypeID_fk']);
// }
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
$sql = "select
	c.clubID,
	bc.contactID,
	cp.contactPointID,
	bm.mediaID,
	c.clubName,
	c.clubAbbr,
	concat(c.city,', ',c.state) 'Location',
	c.distance,
	bc.contactName,
	bc.priority,
	cp.contactPoint,
	ct1.contactType as 'cp_contactType',
	cp.priority,
	bm.media,
	ct2.contactType as 'bm_contactType',
	bm.priority,
	c.active,
	max(year) as 'LastAttended'
from brew_clubs c
left join brew_contacts bc on c.clubID = bc.clubID
left join brew_contactPoints cp on bc.contactID = cp.contactID
left join brew_media bm on c.clubID = bm.clubID
left join contactTypes ct1 on cp.contactTypeID_fk = ct1.contactTypeID
left join contactTypes ct2 on bm.contactTypeID_fk = ct2.contactTypeID
left join brew_attendence ba on c.clubID = ba.clubID and participated = 'Y'
where 1=1 $wheres
group by
	c.clubID,
	bc.contactID,
	cp.contactPointID,
	bm.mediaID,
	c.clubName,
	c.clubAbbr,
	concat(c.city,', ',c.state),
	c.distance,
	bc.contactName,
	bc.priority,
	cp.contactPoint,
	ct1.contactType,
	cp.priority,
	bm.media,
	ct2.contactType,
	bm.priority,
	c.active
order by c.clubName, bc.contactName, cp.contactPoint;";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
$db->close();
?>
