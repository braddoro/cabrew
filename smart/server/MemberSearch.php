<?php
// http://adodb.org/dokuwiki/doku.php?id=v5:reference:connection:connect
require_once '../../../adodb5/adodb.inc.php';
$ini_array = parse_ini_file('../../lib/server.ini', true);
$hostname = $ini_array['database']['hostname'];
$username = $ini_array['databstatusTypeIDase']['username'];
$password = $ini_array['database']['password'];
$database = $ini_array['database']['dbname'];
$db = ADOnewConnection('mysqli');
$db->connect($hostname, $username, $password, $database);
$statusTypeID = "";
if(isset($_REQUEST['statusTypeID_fk'])){
	$statusTypeID = ' where (M.statusTypeID_fk = ' . intval($_REQUEST['statusTypeID_fk']) . ') ';
}
$sql = "select M.memberID, M.statusTypeID_fk, REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', IFNULL(M.midName, ''), ' ', M.lastName),'  ',' ') as 'FullName', M.sex, M.renewalYear, M.lastChangeDate from members M {$statusTypeID} order by M.firstName;";
// echo "/* {$sql} */";
$db->setFetchMode(ADODB_FETCH_ASSOC);
$response = $db->getAll($sql);
if(!$response){
	echo $db->errorMsg();
	die(-4);
}
var_dump($response);
if($response){
	echo json_encode($response);
}else{
	echo json_encode(array());
}
?>
