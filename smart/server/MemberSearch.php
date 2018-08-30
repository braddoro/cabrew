<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$wheres = '';
if(isset($_REQUEST['statusTypeID_fk'])){
	$wheres .= ' and M.statusTypeID_fk = ' . intval($_REQUEST['statusTypeID_fk']);
}
$sql = "select M.memberID, M.statusTypeID_fk, REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', IFNULL(M.midName, ''), ' ', M.lastName),'  ',' ') as 'FullName', M.sex, M.renewalYear, M.lastChangeDate from members M where 1=1 $wheres order by M.firstName;";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
?>
