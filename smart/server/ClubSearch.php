<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
$access_array = parse_ini_file('access.ini', true);
$accesslist = $access_array['access'][basename(__FILE__)];
if((!substr_count($accesslist,$operationType))){
	$response = array('status' => -4, 'errorMessage' => $conn->getMessage(2, $operationType));
	echo json_encode($response);
	exit(1);
}
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
