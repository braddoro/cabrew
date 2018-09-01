<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'web_posts';
$primaryKey = 'webPostID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	$sql = "select * from $table $wheres;";
	$response = $db->getAll($sql);
	break;
case 'add':
	$record['postName'] = $_REQUEST['postName'];
	$record['postText'] = $_REQUEST['postText'];
	$db->AutoExecute($table, $record, 'INSERT');
	echo $db->errorMsg();
	break;
case 'update':
	if(!isset($_REQUEST[$primaryKey])){
		echo 'Missing primary key reference for update operation.';
		exit(-1);
	}
	$record['postName'] = $_REQUEST['postName'];
	$record['postText'] = $_REQUEST['postText'];
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
