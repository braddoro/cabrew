<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'brew_attendence';
$primaryKey = 'attendenceID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	if(isset($_REQUEST['clubID'])){
		$wheres .= ' and clubID = ' . intval($_REQUEST['clubID']);
	}
	if(isset($_REQUEST['year'])){
		$wheres .= ' and year = ' . intval($_REQUEST['year']);
	}
	if(isset($_REQUEST['attended'])){
		$wheres .= ' and attended = ' . intval($_REQUEST['attended']);
	}
	if(isset($_REQUEST['interested'])){
		$qStr = $db->qStr($_REQUEST['interested'], true);
		$wheres .= " and interested = '{$qStr}' ";
	}
	if(isset($_REQUEST['participated'])){
		$qStr = $db->qStr($_REQUEST['participated'], true);
		$wheres .= " and participated = '{$qStr}' ";
	}
	$sql = "select * from $table $wheres";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
case 'add':
	if(isset($_REQUEST['clubID'])){
		$record['clubID'] = intval($_REQUEST['clubID']);
	}
	if(isset($_REQUEST['year'])){
		$record['year'] = intval($_REQUEST['year']);
	}
	if(isset($_REQUEST['attended'])){
		$record['attended'] = intval($_REQUEST['attended']);
	}
	if(isset($_REQUEST['beers'])){
		$record['beers'] = intval($_REQUEST['beers']);
	}
	if(isset($_REQUEST['interested'])){
		$record['interested'] = trim($_REQUEST['interested']);
	}
	if(isset($_REQUEST['participated'])){
		$record['participated'] = trim($_REQUEST['participated']);
	}
	$db->AutoExecute($table, $record, 'INSERT');
	break;
case 'update':
	if(!isset($_REQUEST[$primaryKey])){
		echo 'Missing primary key reference for update operation.';
		exit(-1);
	}
	if(isset($_REQUEST['clubID'])){
		$record['clubID'] = intval($_REQUEST['clubID']);
	}
	if(isset($_REQUEST['year'])){
		$record['year'] = intval($_REQUEST['year']);
	}
	if(isset($_REQUEST['attended'])){
		$record['attended'] = intval($_REQUEST['attended']);
	}
	if(isset($_REQUEST['beers'])){
		$record['beers'] = intval($_REQUEST['beers']);
	}
	if(isset($_REQUEST['interested'])){
		$record['interested'] = trim($_REQUEST['interested']);
	}
	if(isset($_REQUEST['participated'])){
		$record['participated'] = trim($_REQUEST['participated']);
	}
	$record['lastChangeDate'] = date("Y-m-d H:i:s");
	$where = $primaryKey . ' = ' . intval($_REQUEST[$primaryKey]);
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
