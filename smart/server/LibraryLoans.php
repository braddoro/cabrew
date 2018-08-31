<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$sql = "select
	ll.loanID,
	ll.memberID_fk,
	ll.libraryID_fk,
	ll.requestDate,
	ll.loanDate,
	ll.returnDate,
	ll.lastChangeDate
from library_loans ll";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
?>
