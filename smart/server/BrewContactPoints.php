<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
$table = 'brew_contactPoints';
$primaryKey = 'contactPointID';
$conn = new Connect();
$dbconn = $conn->conn();
if(!$dbconn->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $dbconn->errorMsg());
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
switch($operationType){
case 'fetch':
	$where = '1=1';
	if(isset($_REQUEST['contactID'])){
		$where .= ' and contactID = ' . intval($_REQUEST['contactID']);
	}
	if(isset($_REQUEST['contactTypeID_fk'])){
		$where .= ' and contactTypeID_fk = ' . intval($_REQUEST['contactTypeID_fk']);
	}
	if(isset($_REQUEST['priority'])){
		$where .= ' and priority = ' . intval($_REQUEST['priority']);
	}
	if(isset($_REQUEST['contactPoint'])){
		$qStr = $dbconn->qStr($_REQUEST['contactPoint'], true);
		$where .= " and contactPoint like '%" . $qStr . "%' ";
	}
	break;
case 'add':
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	$dbconn->AutoExecute($table, $record, DB_AUTOQUERY_INSERT);
	$pkval = $dbconn->insert_Id();
	$where = $primaryKey . '=' . $pkval;
	break;
case 'update':
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $_REQUEST);
	$record = $conn->buildRecordset($data);
	$where = $primaryKey . '=' . $pkval;
	$dbconn->AutoExecute($table, $record, DB_AUTOQUERY_UPDATE, $where);
 	break;
case 'remove':
	$where = $primaryKey . '=' . $pkval;
	$sql = "delete from {$table} where {$where};";
	$dbconn->execute($sql);
	break;
default:
	break;
}
$arr = array(
	"action" => $operationType,
	"fieldsVals" => var_export($_REQUEST, true),
	"pageName" => basename(__FILE__),
	"primaryKey" => $primaryKey,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"tableName" => $table
);
$r = siteLog($conn, $dbconn, $arr);
$sql = "select * from {$table} where {$where};";
$response = $dbconn->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$dbconn->close();
?>
