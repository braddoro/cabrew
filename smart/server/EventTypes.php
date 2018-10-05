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
	$record['eventType'] = $_REQUEST['eventType'];
	if(isset($_REQUEST['description'])){
		$record['description'] = $_REQUEST['description'];
	}
	$db->AutoExecute($table, $record, 'INSERT');
	echo $db->errorMsg();
	break;
case 'update':
	if(isset($_REQUEST['eventType'])){
		$record['eventType'] = $_REQUEST['eventType'];
	}
	if(isset($_REQUEST['active'])){
		$record['active'] = $_REQUEST['active'];
	}
	if(isset($_REQUEST['description'])){
		$record['description'] = $_REQUEST['description'];
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
	break;
default:
	break;
}
echo json_encode($response);
$db->close();
?>
