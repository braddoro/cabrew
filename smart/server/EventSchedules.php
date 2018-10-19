<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'eventSchedules';
$primaryKey = 'eventScheduleID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	$sql = "select * from $table $wheres;";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
case 'add':
	$record['dayID'] = intval($_REQUEST['dayID']);
	$record['typeID'] = intval($_REQUEST['typeID']);
	$record['eventID'] = intval($_REQUEST['eventID']);
	if(isset($_REQUEST['stepStart'])){
		$record['stepStart'] = trim($_REQUEST['stepStart']);
	}
	if(isset($_REQUEST['step'])){
		$record['step'] = trim($_REQUEST['step']);
	}
	if(isset($_REQUEST['stepDetails'])){
		$record['stepDetails'] = trim($_REQUEST['stepDetails']);
	}
	$db->AutoExecute($table, $record, 'INSERT');
	$sql = "select * from $table where $primaryKey = " . $db->insert_Id();
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
case 'update':
	if(!isset($_REQUEST[$primaryKey])){
		echo 'Missing primary key reference for update operation.';
		exit(-1);
	}
	$record['dayID'] = intval($_REQUEST['dayID']);
	if(isset($_REQUEST['typeID'])){
		$record['typeID'] = intval($_REQUEST['typeID']);
	}
	if(isset($_REQUEST['eventID'])){
		$record['eventID'] = intval($_REQUEST['eventID']);
	}
	if(isset($_REQUEST['stepStart'])){
		$record['stepStart'] = trim($_REQUEST['stepStart']);
	}
	if(isset($_REQUEST['step'])){
		$record['step'] = trim($_REQUEST['step']);
	}
	if(isset($_REQUEST['stepDetails'])){
		$record['stepDetails'] = trim($_REQUEST['stepDetails']);
	}
	$record['lastChangeDate'] = date("Y-m-d H:i:s");
	$where = $primaryKey . ' = ' . $_REQUEST[$primaryKey];
	$db->AutoExecute($table, $record, 'UPDATE', $where);
	$sql = "select * from $table where $where";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
 	break;
case 'remove':
	$where = $primaryKey . ' = ' . $_REQUEST[$primaryKey];
	$sql = "delete from $table where $where";
	$result = $db->execute($sql);
	$sql = "select * from $table where $where";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
default:
	break;
}
echo json_encode($response);
$db->close();
?>
