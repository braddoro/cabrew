<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$sql = "select l.bookID, l.series, l.title, l.author, l.copyright, l.abstract from library_books l";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
?>
