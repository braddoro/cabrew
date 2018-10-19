<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'eventTeamNames';
$primaryKey = 'eventTeamNameID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	if(isset($_REQUEST['active'])){
		$wheres .= " and active = '" . $_REQUEST['active'] . "' ";
	}
	$sql = "select * from $table $wheres;";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
case 'add':
	$record['eventTeamNameID'] = intval($_REQUEST['eventTeamNameID']);
	if(isset($_REQUEST['teamName'])){
		$record['teamName'] = trim($_REQUEST['teamName']);
	}
	if(isset($_REQUEST['teamName'])){
		$record['teamName'] = trim($_REQUEST['teamName']);
	}
	if(isset($_REQUEST['active'])){
		$record['active'] = trim($_REQUEST['active']);
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
	if(isset($_REQUEST['eventTeamNameID'])){
		$record['eventTeamNameID'] = intval($_REQUEST['eventTeamNameID']);
	}
	if(isset($_REQUEST['teamName'])){
		$record['teamName'] = trim($_REQUEST['teamName']);
	}
	if(isset($_REQUEST['active'])){
		$record['active'] = trim($_REQUEST['active']);
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
