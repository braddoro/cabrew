<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
$table = 'sec_users';
$primaryKey = 'secUserID';
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
	// if(isset($_REQUEST['status'])){
	// 	$qStr = $db->qStr($_REQUEST['status'], true);
	// 	$where .= " and status = $qStr ";
	// }
	// if(isset($_REQUEST['eventTypeID'])){
	// 	$where .= ' and eventTypeID = ' . intval($_REQUEST['eventTypeID']);
	// }
	// if(isset($_REQUEST['step'])){
	// 	$where .= " and step like '%" . $_REQUEST['step'] . "%' ";
	// }
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

$mask = $_REQUEST;
$mask['password'] = '************';
$arr = array(
	"action" => $operationType,
	"fieldsVals" => var_export($mask, true),
	"ip_address" => $_SERVER['REMOTE_ADDR'],
	"pageName" => basename(__FILE__),
	"primaryKey" => $primaryKey,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"tableName" => $table
);
$r = siteLog($conn, $db, $arr);
$sql = "select * from {$table} where {$where};";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
