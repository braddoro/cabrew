<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'eventBeers';
$primaryKey = 'eventBeerID';
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
	$record[$primaryKey] = intval($_REQUEST[$primaryKey]);
	$record['eventID'] = intval($_REQUEST['eventID']);
	$record['clubID'] = intval($_REQUEST['clubID']);
	if(isset($_REQUEST['brewerName'])){
		$record['brewerName'] = trim($_REQUEST['brewerName']);
	}
	if(isset($_REQUEST['beerStyle'])){
		$record['beerStyle'] = trim($_REQUEST['beerStyle']);
	}
	if(isset($_REQUEST['beerName'])){
		$record['beerName'] = trim($_REQUEST['beerName']);
	}
	if(isset($_REQUEST['beerStory'])){
		$record['beerStory'] = $_REQUEST['beerStory'];
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
	if(isset($_REQUEST['eventID'])){
		$record['eventID'] = intval($_REQUEST['eventID']);
	}
	if(isset($_REQUEST['clubID'])){
		$record['clubID'] = intval($_REQUEST['clubID']);
	}
	if(isset($_REQUEST['brewerName'])){
		$record['brewerName'] = trim($_REQUEST['brewerName']);
	}
	if(isset($_REQUEST['beerStyle'])){
		$record['beerStyle'] = trim($_REQUEST['beerStyle']);
	}
	if(isset($_REQUEST['beerName'])){
		$record['beerName'] = trim($_REQUEST['beerName']);
	}
	if(isset($_REQUEST['beerStory'])){
		$record['beerStory'] = $_REQUEST['beerStory'];
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