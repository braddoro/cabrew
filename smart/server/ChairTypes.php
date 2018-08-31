<?php
require_once 'Connect.php';
$table = 'chairTypes';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$wheres = '';
if(isset($_REQUEST['active'])){
	$qStr = $db->qStr($_REQUEST['active'], true);
	$wheres .= " and active = $qStr ";
}
$sql = "select * from $table where 1=1 $wheres;";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
$db->close();
?>
