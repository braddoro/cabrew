<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'brew_media';
$primaryKey = 'mediaID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	if(isset($_REQUEST['clubID'])){
		$wheres .= ' and clubID = ' . intval($_REQUEST['clubID']);
	}
	if(isset($_REQUEST['contactTypeID_fk'])){
		$wheres .= ' and contactTypeID_fk = ' . intval($_REQUEST['contactTypeID_fk']);
	}
	if(isset($_REQUEST['priority'])){
		$wheres .= ' and priority = ' . intval($_REQUEST['priority']);
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
	if(isset($_REQUEST['contactTypeID_fk'])){
		$record['contactTypeID_fk'] = intval($_REQUEST['contactTypeID_fk']);
	}
	if(isset($_REQUEST['priority'])){
		$record['priority'] = intval($_REQUEST['priority']);
	}
	if(isset($_REQUEST['media'])){
		$record['media'] = trim($_REQUEST['media']);
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
	if(isset($_REQUEST['contactTypeID_fk'])){
		$record['contactTypeID_fk'] = intval($_REQUEST['contactTypeID_fk']);
	}
	if(isset($_REQUEST['priority'])){
		$record['priority'] = intval($_REQUEST['priority']);
	}
	if(isset($_REQUEST['media'])){
		$record['media'] = trim($_REQUEST['media']);
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
