<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
$table = 'eventPlans';
$primaryKey = 'eventPlanID';
$conn = new Connect();
$dbconn = $conn->conn();
if(!$dbconn->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $dbconn->errorMsg());
	echo json_encode($response);
	exit(1);
}
$pkval = (isset($_REQUEST[$primaryKey])) ? intval($_REQUEST[$primaryKey]) : NULL;
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
$access_array = parse_ini_file('access.ini', true);
$accesslist = $access_array['access'][basename(__FILE__)];
if((!substr_count($accesslist,$operationType))){
	$response = array('status' => -4, 'errorMessage' => $conn->getMessage(2, $operationType));
	echo json_encode($response);
	exit(1);
}
if(($operationType == 'update' || $operationType == 'remove') && is_null($pkval)){
	$response = array('status' => -1, 'errorMessage' => $conn->getMessage(1, $operationType));
	echo json_encode($response);
	exit(1);
}

$_REQUEST['done'] = 'N';
if($_REQUEST['status'] == 'complete'){
	$_REQUEST['done'] = 'Y';
}

switch($operationType){
case 'fetch':
	$where = '1=1';
	if(isset($_REQUEST['status'])){
		$qStr = $dbconn->qStr($_REQUEST['status'], true);
		$where .= " and status = $qStr ";
	}
	if(isset($_REQUEST['eventTypeID'])){
		$where .= ' and eventTypeID = ' . intval($_REQUEST['eventTypeID']);
	}
	if(isset($_REQUEST['step'])){
		$where .= " and step like '%" . $_REQUEST['step'] . "%' ";
	}
	break;
case 'add':
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	$dbconn->AutoExecute($table, $record, DB_AUTOQUERY_INSERT);
	$pkval = $dbconn->insert_Id();
	$where = $primaryKey . '=' . $pkval;
	break;
case 'update':
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	// echo json_encode($record);
	$where = $primaryKey . '=' . $pkval;
	$dbconn->AutoExecute($table, $record, DB_AUTOQUERY_UPDATE, $where);
 	break;
case 'remove':
	$where = $primaryKey . '=' . $pkval;
	$sql = "delete from {$table} where {$where};";
	$dbconn->execute($sql);
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
	"tableName" => $table
);
$r = siteLog($conn, $dbconn, $arr);
$sql = "select * from {$table} where {$where};";
$response = $dbconn->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$dbconn->close();
?>
