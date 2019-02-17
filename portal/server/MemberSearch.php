<?php
require_once 'Connect.php';
$table = 'members';
$primaryKey = 'memberID';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
	echo json_encode($response);
	exit(1);
}
$pkval = (isset($_REQUEST[$primaryKey])) ? intval($_REQUEST[$primaryKey]) : NULL;
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$where = ' M.statusTypeID_fk = 1 ';
	if(isset($_REQUEST['FullName'])){
		$where .= " AND REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ') LIKE '%" . $_REQUEST['FullName'] . "%' ";
	// }else{
	// 	$where .= ' AND M.statusTypeID_fk = 0 ';
	}
	break;
case 'add':
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	$db->AutoExecute($table, $record, DB_AUTOQUERY_INSERT);
	$pkval = $db->insert_Id();
	$where = $primaryKey . '=' . $pkval;
	break;
case 'update':
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	// echo json_encode($record);
	$where = $primaryKey . '=' . $pkval;
	$db->AutoExecute($table, $record, DB_AUTOQUERY_UPDATE, $where);
 	break;
case 'remove':
	$where = $primaryKey . '=' . $pkval;
	$sql = "delete from {$table} where {$where};";
	$db->execute($sql);
	break;
default:
	break;
}
$sql = "select
	M.memberID,
	M.statusTypeID_fk,
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ') as 'FullName',
	M.sex,
	M.renewalYear,
	M.lastChangeDate
	from
	members M
	where {$where}
	order by M.firstName;";
echo "/* $sql */";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
