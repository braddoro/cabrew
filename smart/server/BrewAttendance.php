<?php
require_once 'Connect.php';
$table = 'brew_attendence';
$primaryKey = 'attendenceID';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
	echo json_encode($response);
	exit(1);
}
$pkval = (isset($_REQUEST[$primaryKey])) ? intval($_REQUEST[$primaryKey]) : NULL;
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
if(($operationType == 'update' || $operationType == 'remove') && is_null($pkval)){
	$response = array('status' => -1, 'errorMessage' => $conn->getMessage(1, $operationType));
	echo json_encode($response);
	exit(1);
}
switch($operationType){
case 'fetch':
	$where = '1=1';
	if(isset($_REQUEST['clubID'])){
		$where .= ' and clubID = ' . intval($_REQUEST['clubID']);
	}
	if(isset($_REQUEST['year'])){
		$where .= ' and year = ' . intval($_REQUEST['year']);
	}
	if(isset($_REQUEST['attended'])){
		$where .= ' and attended = ' . intval($_REQUEST['attended']);
	}
	if(isset($_REQUEST['interested'])){
		$qStr = $db->qStr($_REQUEST['interested'], true);
		$where .= " and interested = '{$qStr}' ";
	}
	if(isset($_REQUEST['participated'])){
		$qStr = $db->qStr($_REQUEST['participated'], true);
		$where .= " and participated = '{$qStr}' ";
	}
	break;
case 'add':
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	$db->AutoExecute($table, $record, DB_AUTOQUERY_INSERT);
	$pkval = $db->insert_Id();
	$where = $primaryKey . '=' . $pkval;
	break;
case 'update':
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	// echo json_encode($record);
	$where = $primaryKey . '=' . $pkval;
	$db->AutoExecute($table, $record, DB_AUTOQUERY_UPDATE, $where);
 	break;
case 'remove':
	$where = $primaryKey . '=' . $pkval;
	$sql = "delete from {$table} where {$where};";
	$db->execute($sql);
	break;
default:
	break;
}
$sql = "select * from {$table} where {$where};";
// echo "/* {$sql} */";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
