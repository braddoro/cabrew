<?php
require_once 'Connect.php';
$table = 'brew_contactPoints';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$wheres = ' where 1=1 ';
if(isset($_REQUEST['contactID'])) {
	$wheres .= ' and contactID = ' . intval($_REQUEST['contactID']);
}
if(isset($_REQUEST['contactTypeID_fk'])) {
	$wheres .= ' and contactTypeID_fk = ' . intval($_REQUEST['contactTypeID_fk']);
}
if(isset($_REQUEST['priority'])) {
	$wheres .= ' and priority = ' . intval($_REQUEST['priority']);
}
$sql = "select * from $table $wheres;";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo json_encode(array());
}
$db->close();
?>
