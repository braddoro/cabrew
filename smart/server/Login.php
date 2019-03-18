<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
$table = 'sec_users';
$primaryKey = 'secUserID';
$conn = new Connect();
$db = $conn->conn();
// $db->debug = true;
if(!$db->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
	echo json_encode($response);
	exit(1);
}
$operationType = 'fetch';
$username = $_REQUEST['user_name'];
$password = $_REQUEST['password'];

$mask = $_REQUEST;
$mask['password'] = '************';
$arr = array(
	"action" => $operationType,
	"fieldsVals" => var_export($mask, true),
	"ip_address" => $_SERVER['REMOTE_ADDR'],
	"pageName" => basename(__FILE__),
	"primaryKey" => $primaryKey,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"tableName" => $table
);
$r = siteLog($conn, $db, $arr, true);
$sql = "select secUserID, userName from sec_users where LOWER(userName) = LOWER('{$username}') and LOWER(password) = LOWER('{$password}') and active = 'Y';";
$response = $db->getAll($sql);
if(!$response){
	$response = json_encode(array());
}
$db->close();
echo json_encode($response);
?>
