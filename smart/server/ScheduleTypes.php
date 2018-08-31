<?php
session_start();
require_once 'Connect.php';
if (isset($_SESSION['db'])){
	$db = $_SESSION['db'];
}else{
	$conn = new Connect();
	$db = $conn->conn();
}
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$sql = "select * from checklistTypes where active = 'Y';";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
?>
