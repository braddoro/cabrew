<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$wheres = '';
if(isset($_REQUEST['memberID_fk'])) {
	$wheres .= ' and memberID_fk = ' . intval($_REQUEST['memberID_fk']);
}
$sql = "select * from memberNotes c where 1=1 $wheres;";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
?>
