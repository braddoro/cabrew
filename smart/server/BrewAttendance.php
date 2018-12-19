<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
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
$access_array = parse_ini_file('access.ini', true);
$accesslist = $access_array['access'][basename(__FILE__)];
if((!substr_count($accesslist,$operationType))){
	$response = array('status' => -4, 'errorMessage' => $conn->getMessage(2, $operationType));
	echo json_encode($response);
	exit(1);
}
if(($operationType == 'update' || $operationType == 'remove') && is_null($pkval)){
	$response = array('status' => -1, 'errorMessage' => $conn->getMessage(1, $operationType));
	echo json_encode($response);
	exit(1);
}
switch($operationType){
case 'fetch':
	$where = '1=1';
	if(isset($_REQUEST['clubID'])){
		$where .= ' and ba.clubID = ' . intval($_REQUEST['clubID']);
	}
	if(isset($_REQUEST['eventID'])){
		$where .= ' and ba.eventID = ' . intval($_REQUEST['eventID']);
	}
	if(isset($_REQUEST['year'])){
		$where .= ' and ba.year = ' . intval($_REQUEST['year']);
	}
	if(isset($_REQUEST['attended'])){
		$where .= ' and ba.attended = ' . intval($_REQUEST['attended']);
	}
	if(isset($_REQUEST['interested'])){
		$qStr = $db->qStr($_REQUEST['interested'], true);
		$where .= " and ba.interested = '{$qStr}' ";
	}
	if(isset($_REQUEST['participated'])){
		$qStr = $db->qStr($_REQUEST['participated'], true);
		$where .= " and ba.participated = '{$qStr}' ";
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
$arr = array(
	"pageName" => basename(__FILE__),
	"action" => $operationType,
	"tableName" => $table,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"primaryKey" => $primaryKey,
	"fieldsVals" => var_export($_REQUEST, true)
);
$r = siteLog($conn, $db, $arr);
$sql = "select ba.*, bc.distance from {$table} ba left join brew_clubs bc on ba.clubID = bc.clubID where {$where};";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
