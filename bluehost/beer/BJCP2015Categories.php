<?php
require_once '../shared/Connect.php';
// require_once 'SiteLog.php';
$table = 'bjcp2015_categories';
$primaryKey = 'bjcp2015_categoryID';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
	echo json_encode($response);
	exit(1);
}
$pkval = (isset($_REQUEST[$primaryKey])) ? intval($_REQUEST[$primaryKey]) : null;
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$where = '1=1';
	if(isset($_REQUEST['bjcp2015_categoryID'])){
		$where .= " and bjcp2015_categoryID = " . intval($_REQUEST['bjcp2015_categoryID']);
	}
	if(isset($_REQUEST['bjcpCategory'])){
		$where .= " and bjcpCategory = '" . $_REQUEST['bjcpCategory']. "'";
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
// $arr = array(
// 	"action" => $operationType,
// 	"fieldsVals" => var_export($_REQUEST, true),
// 	"ip_address" => $_SERVER['REMOTE_ADDR'],
// 	"pageName" => basename(__FILE__),
// 	"primaryKey" => $primaryKey,
// 	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
// 	"tableName" => $table,
// 	"userID" => (isset($_REQUEST['userID'])) ? intval($_REQUEST['userID']): 0
// );
// $r = siteLog($conn, $db, $arr);
$sql = "select * from {$table} where {$where} order by bjcp2015_category;";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
