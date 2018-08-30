<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$wheres = '';
if(isset($_REQUEST['memberID'])) {
	$wheres .= ' and d.memberID = ' . intval($_REQUEST['memberID']);
}
if(isset($_REQUEST['YearDate'])) {
	$wheres .= ' and year(d.memberDate) = ' . intval($_REQUEST['YearDate']);
}
if(isset($_REQUEST['dateTypeID_fk'])) {
	$wheres .= ' and d.dateTypeID_fk = ' . intval($_REQUEST['dateTypeID_fk']);
}
$sql = "select d.*, year(d.memberdate) as 'YearDate' from memberDates d where 1=1 $wheres order by d.memberdate desc";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
?>
