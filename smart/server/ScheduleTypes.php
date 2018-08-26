<?php
// http://adodb.org/dokuwiki/doku.php?id=v5:reference:connection:connect
require_once '../../../adodb5/adodb.inc.php';
$ini_array = parse_ini_file('../../lib/server.ini', true);
$hostname = $ini_array['database']['hostname'];
$username = $ini_array['database']['username'];
$password = $ini_array['database']['password'];
$database = $ini_array['database']['dbname'];
$db = ADOnewConnection('mysqli');
$db->connect($hostname, $username, $password, $database);
$sql = "select * from checklistTypes;";
$db->setFetchMode(ADODB_FETCH_ASSOC);
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo json_encode(array());
}
?>
