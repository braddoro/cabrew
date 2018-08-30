<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$sql = "select distinct year(memberDate) as 'Year' from memberDates where year(memberDate) > 2014 order by memberDate;";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
?>
