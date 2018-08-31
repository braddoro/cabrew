<?php
session_start();
$response = array();
require_once 'Connect.php';
if (isset($_SESSION['db'])){
	$db = $_SESSION['db'];
}else{
	$conn = new Connect();
	$db = $conn->conn();
}
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'eventData';
$primaryKey = 'eventDataID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	if(isset($_REQUEST['status'])){
		$qStr = $db->qStr($_REQUEST['status'], true);
		$wheres .= " and status = $qStr ";
	}
	if(isset($_REQUEST['eventTypeID'])){
		$wheres .= ' and eventTypeID = ' . intval($_REQUEST['eventTypeID']);
	}
	$sql = "select * from $table $wheres order by dueDate";
	$response = $db->getAll($sql);
	break;
case 'add':
	$record['eventTypeID'] = intval($_REQUEST['eventTypeID']);
	$record['memberID'] = intval($_REQUEST['memberID']);
	$record['dueDate'] = $_REQUEST['dueDate'];
	if(isset($_REQUEST['step'])){
		$record['step'] = $db->qStr($_REQUEST['step']);
	}
	if(isset($_REQUEST['status'])){
		$record['status'] = $db->qStr($_REQUEST['status']);
	}
	if(isset($_REQUEST['cost'])){
		$record['cost'] = $db->qStr($_REQUEST['cost']);
	}
	if(isset($_REQUEST['notes'])){
		$record['notes'] = $db->qStr($_REQUEST['notes']);
	}
	$db->AutoExecute($table, $record, 'INSERT');
	echo $db->errorMsg();
	break;
case 'update':
	if(isset($_REQUEST['eventTypeID'])){
		$record['eventTypeID'] = $_REQUEST['eventTypeID'];
	}
	if(isset($_REQUEST['memberID'])){
		$record['memberID'] = $_REQUEST['memberID'];
	}
	if(isset($_REQUEST['dueDate'])){
		$record['dueDate'] = $_REQUEST['dueDate'];
	}
	if(isset($_REQUEST['step'])){
		$record['step'] = $_REQUEST['step'];
	}
	if(isset($_REQUEST['status'])){
		$record['status'] = $_REQUEST['status'];
	}
	if(isset($_REQUEST['cost'])){
		$record['cost'] = $_REQUEST['cost'];
	}
	if(isset($_REQUEST['notes'])){
		$record['notes'] = $_REQUEST['notes'];
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
?>
