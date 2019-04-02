<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
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
	$where = '1=1';
	if(isset($_REQUEST['statusTypeID_fk'])){
		$where .= ' and M.statusTypeID_fk = ' . intval($_REQUEST['statusTypeID_fk']);
	}
	if(isset($_REQUEST['FullName'])){
		$where .= " and REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', IFNULL(M.midName, ''), ' ', M.lastName),'  ',' ') like '%" . $_REQUEST['FullName'] . "%' ";
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
$arr = array(
	"action" => $operationType,
	"fieldsVals" => var_export($_REQUEST, true),
	"ip_address" => $_SERVER['REMOTE_ADDR'],
	"pageName" => basename(__FILE__),
	"primaryKey" => $primaryKey,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"tableName" => $table,
	"userID" => (isset($_REQUEST['userID'])) ? intval($_REQUEST['userID']): 0
);
$r = siteLog($conn, $db, $arr);
$sql = "select
	M.memberID,
	M.statusTypeID_fk,
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', IFNULL(M.midName, ''), ' ', M.lastName),'  ',' ') as 'FullName',
	M.sex,
	M.renewalYear,
	M.lastChangeDate,
	max(coalesce(d.memberDate,'')) 'LastAttended'
	from
	members M
	left join memberDates d on M.memberID = d.memberID_fk and d.dateTypeID_fk = 6
	where {$where}
	group by
		M.memberID,
		M.statusTypeID_fk,
		REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', IFNULL(M.midName, ''), ' ', M.lastName),'  ',' '),
		M.sex,
		M.renewalYear,
		M.lastChangeDate
	order by
		M.firstName;";
$response = $db->getAll($sql);
if(!$response){
	$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
	echo json_encode($response);
	exit(1);
	// $response = array();
}
echo json_encode($response);
$db->close();
?>
