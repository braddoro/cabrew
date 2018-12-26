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

$where = '1=1';
// if(isset($_REQUEST['active'])){
// 	$qStr = $db->qStr($_REQUEST['active'], true);
// 	$where .= " and active = $qStr ";
// }
// if(isset($_REQUEST['memberID'])){
// 	$where .= " and memberID = " . intval($_REQUEST['memberID']);
// }

$sql = "select * from {$table} where {$where} order by {$primaryKey} desc;";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
