<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'members';
$primaryKey = 'memberID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	if(isset($_REQUEST['memberID'])){
		$wheres .= " and memberID = " . intval($_REQUEST['memberID']) . " ";
	}
	if(isset($_REQUEST['statusTypeID_fk'])){
		$wheres .= " and statusTypeID_fk = " . intval($_REQUEST['statusTypeID_fk']) . " ";
	}
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
	$record['memberID'] = intval($_REQUEST['memberID']);
	$record['statusTypeID_fk'] = intval($_REQUEST['statusTypeID_fk']);
	$record['renewalYear'] = intval($_REQUEST['renewalYear']);
	if(isset($_REQUEST['firstName'])){
		$record['firstName'] = trim($_REQUEST['firstName']);
	}
	if(isset($_REQUEST['midName'])){
		$record['midName'] = trim($_REQUEST['midName']);
	}
	if(isset($_REQUEST['lastName'])){
		$record['lastName'] = trim($_REQUEST['lastName']);
	}
	if(isset($_REQUEST['nickname'])){
		$record['nickname'] = trim($_REQUEST['nickname']);
	}
	if(isset($_REQUEST['sex'])){
		$record['sex'] = trim($_REQUEST['sex']);
	}
	$db->AutoExecute($table, $record, 'INSERT');
	break;
case 'update':
	if(!isset($_REQUEST[$primaryKey])){
		echo 'Missing primary key reference for update operation.';
		exit(-1);
	}
	if(isset($_REQUEST['memberID'])){
		$record['memberID'] = intval($_REQUEST['memberID']);
	}
	if(isset($_REQUEST['statusTypeID_fk'])){
		$record['statusTypeID_fk'] = intval($_REQUEST['statusTypeID_fk']);
	}
	if(isset($_REQUEST['renewalYear'])){
		$record['renewalYear'] = intval($_REQUEST['renewalYear']);
	}
	if(isset($_REQUEST['firstName'])){
		$record['firstName'] = trim($_REQUEST['firstName']);
	}
	if(isset($_REQUEST['midName'])){
		$record['midName'] = trim($_REQUEST['midName']);
	}
	if(isset($_REQUEST['lastName'])){
		$record['lastName'] = trim($_REQUEST['lastName']);
	}
	if(isset($_REQUEST['nickname'])){
		$record['nickname'] = trim($_REQUEST['nickname']);
	}
	if(isset($_REQUEST['sex'])){
		$record['sex'] = $_REQUEST['sex'];
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
