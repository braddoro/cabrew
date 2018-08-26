<?php
// http://adodb.org/dokuwiki/doku.php?id=v5:reference:connection:connect
require_once '../../../adodb5/adodb.inc.php';
$table = 'threadTypes';
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
	$record['threadType'] = $argsIN['threadType'];
	$record['active']  = $argsIN['active'];
	$db->AutoExecute($table, $record, 'INSERT');
	break;
case 'update':
	if(isset($argsIN['threadType'])){
		$record['threadType'] =	$argsIN['threadType'];
	}
	if(isset($argsIN['active'])){
		$record['active'] =	$argsIN['active'];
	}
	$record['lastChangeDate'] = date("Y-m-d H:i:s");
	$where = 'threadTypeID = ' . $argsIN['threadTypeID'];
	$db->AutoExecute($table, $record, 'UPDATE', $where);
	$sql = "select * from $table where $where";
	$db->setFetchMode(ADODB_FETCH_ASSOC);
	$response = $db->getAll($sql);
 	break;
case 'remove':
	$where = 'threadTypeID = ' . $argsIN['threadTypeID'];
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
