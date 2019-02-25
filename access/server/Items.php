<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
$table = 'sec_items';
$primaryKey = 'secItemID';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
	echo json_encode($response);
	exit(1);
}
$pkval = (isset($_REQUEST[$primaryKey])) ? intval($_REQUEST[$primaryKey]) : NULL;
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
// $access_array = parse_ini_file('access.ini', true);
// $accesslist = $access_array['access'][basename(__FILE__)];
// if((!substr_count($accesslist,$operationType))){
// 	$response = array('status' => -4, 'errorMessage' => $conn->getMessage(2, $operationType));
// 	echo json_encode($response);
// 	exit(1);
// }
// if(($operationType == 'update' || $operationType == 'remove') && is_null($pkval)){
// 	$response = array('status' => -1, 'errorMessage' => $conn->getMessage(1, $operationType));
// 	echo json_encode($response);
// 	exit(1);
// }
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
$arr = array(
	"pageName" => basename(__FILE__),
	"action" => $operationType,
	"tableName" => $table,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"primaryKey" => $primaryKey,
	"fieldsVals" => var_export($_REQUEST, true)
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
