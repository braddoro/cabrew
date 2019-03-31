<?php
require_once 'Connect.php';
$table = 'siteLog';
$primaryKey = 'siteLogID';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
	echo json_encode($response);
	exit(1);
}
$sql = "select l.* , u.fullName from siteLog l left join sec_users u on l.userID = u.secUserID order by siteLogID desc;";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
