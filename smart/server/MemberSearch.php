<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$wheres = ' where 1=1 ';
if(isset($_REQUEST['statusTypeID_fk'])){
	$wheres .= ' and M.statusTypeID_fk = ' . intval($_REQUEST['statusTypeID_fk']);
}
if(isset($_REQUEST['FullName'])){
	$wheres .= " and REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', IFNULL(M.midName, ''), ' ', M.lastName),'  ',' ') like '%" . $_REQUEST['FullName'] . "%' ";
}
$sql = "select M.memberID, M.statusTypeID_fk, REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', IFNULL(M.midName, ''), ' ', M.lastName),'  ',' ') as 'FullName', M.sex, M.renewalYear, M.lastChangeDate from members M $wheres order by M.firstName;";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
$db->close();
?>
