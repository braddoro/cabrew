<?php
require_once 'Connect.php';
$table = 'library_books';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$sql = "select * from $table";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
$db->close();
?>
