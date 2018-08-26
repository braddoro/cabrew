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
$sql = "select * from statusTypes";
$db->setFetchMode(ADODB_FETCH_ASSOC);
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo json_encode(array());
}
// // _local
// require_once('../../lib/DataModel.php');
// $params = array(
// 	'baseTable' => 'statusTypes',
// 	'pk_col' => 'statusTypeID',
// 	'allowedOperations' => array('fetch', 'add', 'update','remove'),
// 	'ini_file' => realpath('../../lib/server.ini')
// );
// $lclass = New DataModel();
// $lclass->init($params);
// if($lclass->status != 0){
// 	$response = array('status' => $lclass->status, 'errorMessage' => $lclass->errorMessage);
// 	echo json_encode($response);
// 	exit;
// }
// $argsIN = array_merge($_POST,$_GET);
// $operationType = (isset($argsIN['operationType'])) ? $argsIN['operationType'] : null;
// switch($operationType){
// case 'fetch':
// 	// $wheres = '';
// 	// if(isset($argsIN['active'])) {
// 	// 	$active = ($argsIN['active'] > '') ? $argsIN['active'] : 'Y';
// 	// 	$wheres = "and st.active = '$active'";
// 	// }
// 	// $argsIN['sql'] = "select * from statusTypes st where st.statusTypeID = coalesce(:id, st.statusTypeID) $wheres;";
// 	$response = $lclass->pdoFetch($argsIN);
// 	break;
// case 'add':
// 	$response = $lclass->pdoAdd($argsIN);
// 	break;
// case 'update':
// 	$response = $lclass->pdoUpdate($argsIN);
// 	break;
// case 'remove':
// 	$response = $lclass->pdoRemove($argsIN);
// 	break;
// default:
// 	$response = array('status' => 0);
// 	break;
// }
// echo json_encode($response);
?>
