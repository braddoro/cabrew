<?php
require_once 'Connect.php';
$response = array();
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$table = 'eventTeams';
$primaryKey = 'eventTeamID';
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = ' where 1=1 ';
	if(isset($_REQUEST['eventID'])){
		$wheres .= " and eventID = " . intval($_REQUEST['eventID']) . " ";
	}
	if(isset($_REQUEST['eventTeamNameID'])){
		$wheres .= " and eventTeamNameID = " . intval($_REQUEST['eventTeamNameID']) . " ";
	}
	if(isset($_REQUEST['teamMember'])){
		$wheres .= " and teamMember = '" . $_REQUEST['teamMember'] . "' ";
	}
	$sql = "select * from $table $wheres;";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
case 'add':
	$record['eventTeamID'] = intval($_REQUEST['eventTeamID']);
	$record['eventID'] = intval($_REQUEST['eventID']);
	if(isset($_REQUEST['workTeam'])){
		$record['eventDay'] = $_REQUEST['eventDay'];
	}
	if(isset($_REQUEST['eventTeamNameID'])){
		$record['eventTeamNameID'] = intval($_REQUEST['eventTeamNameID']);
	}
	if(isset($_REQUEST['teamMember'])){
		$record['teamMember'] = trim($_REQUEST['teamMember']);
	}
	if(isset($_REQUEST['startTime'])){
		$record['startTime'] = trim($_REQUEST['startTime']);
	}
	if(isset($_REQUEST['endTime'])){
		$record['endTime'] = trim($_REQUEST['endTime']);
	}
	if(isset($_REQUEST['notes'])){
		$record['notes'] = trim($_REQUEST['notes']);
	}
	$db->AutoExecute($table, $record, 'INSERT');
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
	if(isset($_REQUEST['eventTeamID'])){
		$record['eventTeamID'] = intval($_REQUEST['eventTeamID']);
	}
	if(isset($_REQUEST['eventID'])){
		$record['eventID'] = intval($_REQUEST['eventID']);
	}
	if(isset($_REQUEST['eventDay'])){
		$record['eventDay'] = trim($_REQUEST['eventDay']);
	}
	if(isset($_REQUEST['eventTeamNameID'])){
		$record['eventTeamNameID'] = intval($_REQUEST['eventTeamNameID']);
	}
	if(isset($_REQUEST['teamMember'])){
		$record['teamMember'] = trim($_REQUEST['teamMember']);
	}
	if(isset($_REQUEST['startTime'])){
		$record['startTime'] = trim($_REQUEST['startTime']);
	}
	if(isset($_REQUEST['endTime'])){
		$record['endTime'] = trim($_REQUEST['endTime']);
	}
	if(isset($_REQUEST['notes'])){
		$record['notes'] = trim($_REQUEST['notes']);
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
