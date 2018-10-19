<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'brew_contacts';
$primaryKey = 'contactID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	if(isset($_REQUEST['clubID'])){
		$wheres .= ' and clubID = ' . intval($_REQUEST['clubID']);
	}
	if(isset($_REQUEST['priority'])){
		$wheres .= ' and priority = ' . intval($_REQUEST['priority']);
	}
	if(isset($_REQUEST['contactName'])){
		$qStr = $db->qStr($_REQUEST['contactName'], true);
		$wheres .= " and contactName like '%" . $qStr . "%' ";
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
	if(isset($_REQUEST['priority'])){
		$record['priority'] = intval($_REQUEST['priority']);
	}
	if(isset($_REQUEST['contactName'])){
		$record['contactName'] = trim($_REQUEST['contactName']);
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
	if(isset($_REQUEST['clubID'])){
		$record['clubID'] = intval($_REQUEST['clubID']);
	}
	if(isset($_REQUEST['priority'])){
		$record['priority'] = intval($_REQUEST['priority']);
	}
	if(isset($_REQUEST['contactName'])){
		$record['contactName'] = trim($_REQUEST['contactName']);
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
