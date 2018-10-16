<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'brew_clubs';
$primaryKey = 'clubID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	if(isset($_REQUEST['active'])){
		$qStr = $db->qStr($_REQUEST['active'], true);
		$wheres .= " and active = $qStr ";
	}
	if(isset($_REQUEST['distance'])){
		$wheres .= ' and distance <= ' . intval($_REQUEST['distance']);
	}
	if(isset($_REQUEST['updated'])){
		$wheres .= ' and updated = ' . intval($_REQUEST['updated']);
	}
	if(isset($_REQUEST['clubName'])){
		$qStr = $db->qStr($_REQUEST['clubName'], true);
		$wheres .= " and clubName like '%" . $qStr . "%' ";
	}
	$sql = "select * from $table $wheres";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
case 'add':
	// $record['clubID'] = intval($_REQUEST['clubID']);
	if(isset($_REQUEST['updated'])){
		$record['updated'] = intval($_REQUEST['updated']);
	}
	if(isset($_REQUEST['clubName'])){
		$record['clubName'] = trim($_REQUEST['clubName']);
	}
	if(isset($_REQUEST['clubAbbr'])){
		$record['clubAbbr'] = trim($_REQUEST['clubAbbr']);
	}
	if(isset($_REQUEST['distance'])){
		$record['distance'] = intval($_REQUEST['distance']);
	}
	if(isset($_REQUEST['city'])){
		$record['city'] = trim($_REQUEST['city']);
	}
	if(isset($_REQUEST['state'])){
		$record['state'] = trim($_REQUEST['state']);
	}
	if(isset($_REQUEST['active'])){
		$record['active'] = trim($_REQUEST['active']);
	}
	$db->AutoExecute($table, $record, 'INSERT');
	break;
case 'update':
	if(!isset($_REQUEST[$primaryKey])){
		echo 'Missing primary key reference for update operation.';
		exit(-1);
	}
	$record['clubID'] = intval($_REQUEST['clubID']);
	if(isset($_REQUEST['updated'])){
		$record['updated'] = intval($_REQUEST['updated']);
	}
	if(isset($_REQUEST['clubName'])){
		$record['clubName'] = trim($_REQUEST['clubName']);
	}
	if(isset($_REQUEST['clubAbbr'])){
		$record['clubAbbr'] = trim($_REQUEST['clubAbbr']);
	}
	if(isset($_REQUEST['distance'])){
		$record['distance'] = intval($_REQUEST['distance']);
	}
	if(isset($_REQUEST['city'])){
		$record['city'] = trim($_REQUEST['city']);
	}
	if(isset($_REQUEST['state'])){
		$record['state'] = trim($_REQUEST['state']);
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
	break;
default:
	break;
}
echo json_encode($response);
$db->close();
?>
