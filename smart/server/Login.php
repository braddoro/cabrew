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
$username = $_REQUEST['USER_NAME'];
$password = $_REQUEST['PASSWORD'];

$arr = array(
	"pageName" => basename(__FILE__),
	"action" => $operationType,
	"tableName" => $table,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"primaryKey" => $primaryKey,
	"fieldsVals" => var_export($_REQUEST, true)
);
$r = siteLog($conn, $db, $arr);
$sql = "select secUserID, userName from sec_users where LOWER(userName) = LOWER('{$username}') and LOWER(password) = LOWER('{$password}') and active = 'Y';";
$response = $db->getAll($sql);
if(!$response){
	$response = json_encode(array());
}
$db->close();
echo json_encode($response);
?>
