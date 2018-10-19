<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'eventPlans';
$primaryKey = 'eventPlanID';
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
	if(isset($_REQUEST['step'])){
		$wheres .= " and step like '%" . $_REQUEST['step'] . "%' ";
	}
	$sql = "select * from $table $wheres order by dueDate";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
case 'add':
	$record['eventTypeID'] = intval($_REQUEST['eventTypeID']);
	$record['memberID'] = intval($_REQUEST['memberID']);
	$record['dueDate'] = $_REQUEST['dueDate'];
	if(isset($_REQUEST['step'])){
		$record['step'] = $_REQUEST['step'];
	}
	if(isset($_REQUEST['status'])){
		$record['status'] = $_REQUEST['status'];
	}
	if(isset($_REQUEST['cost'])){
		$record['cost'] = floatval($_REQUEST['cost']);
	}
	if(isset($_REQUEST['notes'])){
		$record['notes'] = $_REQUEST['notes'];
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
	if(isset($_REQUEST['eventTypeID'])){
		$record['eventTypeID'] = intval($_REQUEST['eventTypeID']);
	}
	if(isset($_REQUEST['memberID'])){
		$record['memberID'] = intval($_REQUEST['memberID']);
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
		$record['cost'] = floatval($_REQUEST['cost']);
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
