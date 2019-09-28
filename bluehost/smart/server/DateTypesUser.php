<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
	echo json_encode($response);
	exit(1);
}
$pkval = (isset($_REQUEST[$primaryKey])) ? intval($_REQUEST[$primaryKey]) : NULL;
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
$sql = "select dateTypeID, dateType from sec_user_date_types where DateUserID = 0 order by dateType;";
if(isset($_REQUEST['userID'])){
	$userID = intval($_REQUEST['userID']);
	$sql = "select DT.dateTypeID, DT.dateType from dateTypes DT inner join sec_user_date_types UDT on DT.dateTypeID = UDT.DateTypeID WHERE UDT.DateUserID = $userID and DT.active = 'Y' order by DT.dateType;";
}
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
