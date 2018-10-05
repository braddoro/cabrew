<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$table = 'memberDates';
$primaryKey = 'memberDateID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
$response = array();
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	if(isset($_REQUEST['memberID_fk'])) {
		$wheres .= ' and memberID_fk = ' . intval($_REQUEST['memberID_fk']);
	}
	if(isset($_REQUEST['dateTypeID_fk'])) {
		$wheres .= ' and dateTypeID_fk = ' . intval($_REQUEST['dateTypeID_fk']);
	}
	$sql = "select * from memberDates $wheres;";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
case 'add':
	$record['memberID_fk'] = intval($_REQUEST['memberID_fk']);
	$record['dateTypeID_fk'] = intval($_REQUEST['dateTypeID_fk']);
	$record['memberDate'] = $_REQUEST['memberDate'];
	if(isset($_REQUEST['dateDetail'])){
		$record['dateDetail'] = $_REQUEST['dateDetail'];
	}
	$db->AutoExecute($table, $record, 'INSERT');
	break;
case 'remove':
	if(!isset($_REQUEST[$primaryKey])){
		echo 'Missing primary key reference for remove operation.';
		exit(-1);
	}
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
if($response){
	echo json_encode($response);
}else{
	echo json_encode(array());
}
$db->close();
?>
