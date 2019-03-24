<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
$table = 'memberDates';
$primaryKey = 'memberDateID';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
	echo json_encode($response);
	exit(1);
}
$pkval = (isset($_REQUEST[$primaryKey])) ? intval($_REQUEST[$primaryKey]) : NULL;
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$where = '1=1';
	if(isset($_REQUEST['year'])){
		$where .= " and year(d.memberDate) = " . intval($_REQUEST['year']);
	}
	if(isset($_REQUEST['year'])){
		$where .= " and dt.datePoints > 1";
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
	"action" => $operationType,
	"fieldsVals" => var_export($_REQUEST, true),
	"ip_address" => $_SERVER['REMOTE_ADDR'],
	"pageName" => basename(__FILE__),
	"primaryKey" => $primaryKey,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"tableName" => $table,
	"userID" => (isset($_REQUEST['userID'])) ? intval($_REQUEST['userID']): 0
);
$r = siteLog($conn, $db, $arr);
$sql = "select
	m.memberID,
	REPLACE(CONCAT(IFNULL(m.nickName,m.firstName), ' ', m.lastName),'  ',' ') as 'FullName',
	dt.dateTypeID,
	dt.datePoints,
	year(d.memberDate) as 'Year',
	d.memberDate,
	d.dateDetail,
	m.sex,
	m.lastName,
	m.firstName,
	m.statusTypeID_fk
from
	memberDates d
	inner join members m on m.memberID = d.memberID_fk
	inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
where
	{$where}
order by
	d.memberDate,
	dt.dateType;";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
