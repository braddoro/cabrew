<?php
require_once '../../../adodb5/adodb.inc.php';
$table = 'eventData';
$primaryKey = 'eventDataID';
$ini_array = parse_ini_file('../../lib/server.ini', true);
$hostname = $ini_array['database']['hostname'];
$username = $ini_array['database']['username'];
$password = $ini_array['database']['password'];
$database = $ini_array['database']['dbname'];
$db = ADOnewConnection('mysqli');
$db->connect($hostname, $username, $password, $database);
$argsIN = array_merge($_POST,$_GET);
$operationType = (isset($argsIN['operationType'])) ? $argsIN['operationType'] : null;
switch($operationType){
case 'fetch':
	$sql = "select * from $table";
	$db->setFetchMode(ADODB_FETCH_ASSOC);
	$response = $db->getAll($sql);
	break;
case 'add':
	$record['eventTypeID'] = $argsIN['eventTypeID'];
	$record['threadTypeID']  = $argsIN['threadTypeID'];
	$record['statusTypeID']  = $argsIN['statusTypeID'];
	$record['memberID']  = $argsIN['memberID'];
	$record['dueDate']  = $argsIN['dueDate'];
	$record['step']  = $argsIN['step'];
	$record['thread']  = $argsIN['thread'];
	$record['status']  = $argsIN['status'];
	$record['cost']  = $argsIN['cost'];
	$record['notes']  = $argsIN['notes'];
	// $record['lastChangeDate']  = date("Y-m-d H:i:s");
	$db->AutoExecute($table, $record, 'INSERT');
	break;
case 'update':
	if(isset($argsIN['eventTypeID'])){
		$record['eventTypeID'] = $argsIN['eventTypeID'];
	}
	if(isset($argsIN['threadTypeID'])){
		$record['threadTypeID'] = $argsIN['threadTypeID'];
	}
	if(isset($argsIN['statusTypeID'])){
		$record['statusTypeID'] = $argsIN['statusTypeID'];
	}
	if(isset($argsIN['memberID'])){
		$record['memberID'] = $argsIN['memberID'];
	}
	if(isset($argsIN['dueDate'])){
		$record['dueDate'] = $argsIN['dueDate'];
	}
	if(isset($argsIN['step'])){
		$record['step'] = $argsIN['step'];
	}
	if(isset($argsIN['thread'])){
		$record['thread'] = $argsIN['thread'];
	}
	if(isset($argsIN['status'])){
		$record['status'] = $argsIN['status'];
	}
	if(isset($argsIN['cost'])){
		$record['cost'] = $argsIN['cost'];
	}
	if(isset($argsIN['notes'])){
		$record['notes'] = $argsIN['notes'];
	}
	$record['lastChangeDate'] = date("Y-m-d H:i:s");
	$where = $primaryKey . ' = ' . $argsIN[$primaryKey];
	$db->AutoExecute($table, $record, 'UPDATE', $where);
	$sql = "select * from $table where $where";
	$db->setFetchMode(ADODB_FETCH_ASSOC);
	$response = $db->getAll($sql);
 	break;
case 'remove':
	$where = $primaryKey . ' = ' . $argsIN[$primaryKey];
	$sql = "delete from $table where $where";
	$result = $db->execute($sql);
	$sql = "select * from $table where $where";
	$db->setFetchMode(ADODB_FETCH_ASSOC);
	$response = $db->getAll($sql);
	break;
default:
	break;
}
echo json_encode($response);
?>
