<?php
require_once 'Connect.php';
$table = 'eventTypes';
$primaryKey = 'eventTypeID';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = '';
	if(isset($_REQUEST['active'])){
		$qStr = $db->qStr($_REQUEST['active'], true);
		$wheres .= " and active = $qStr ";
	}
	$sql = "select * from $table where 1=1 $wheres;";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(-1);
	}
	break;
case 'add':
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	$db->AutoExecute($table, $record, DB_AUTOQUERY_INSERT);
	$sql = "select * from $table where $primaryKey = " . $db->insert_Id();
	$response = $db->getAll($sql);
	if(!$response){
		$response = array('status' => -1, 'errormessage' => $db->errorMsg());
		exit(1);
	}
	break;
case 'update':
	if(!isset($_REQUEST[$primaryKey])){
		$response = array('status' => -1, 'errormessage' => 'No Primary Key sent.');
		echo json_encode($response);
		exit(1)
	}
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	$db->AutoExecute($table, $record, DB_AUTOQUERY_UPDATE, $where);
	$sql = "select * from $table where {$primaryKey} = " . intval($_REQUEST[$primaryKey]);
	$response = $db->getAll($sql);
	if(!$response){
		$response = array('status' => -1, 'errormessage' => $db->errorMsg());
		echo json_encode($response);
		exit(1);
	}
 	break;
case 'remove':
	$sql = "delete from {$table} where {$primaryKey} = " . intval($_REQUEST[$primaryKey]);
	$result = $db->execute($sql);
	$sql = "select * from {$table} where {$primaryKey} = " . intval($_REQUEST[$primaryKey]);
	$response = $db->getAll($sql);
	if(!$response){
		$response = array('status' => -1, 'errormessage' => $db->errorMsg());
		exit(1);
	}
	break;
default:
	break;
}
echo json_encode($response);
$db->close();
?>
