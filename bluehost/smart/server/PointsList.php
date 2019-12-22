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
$pkval = (isset($_REQUEST[$primaryKey])) ? intval($_REQUEST[$primaryKey]) : null;
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$where = 'dt.datePoints > 0 ';
	if(isset($_REQUEST['memberID'])) {
		$where .= ' and m.memberID = ' . intval($_REQUEST['memberID']);
	}
	if(isset($_REQUEST['year'])) {
		$where .= ' and year(d.memberDate) = ' . intval($_REQUEST['year']);
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
		d.memberDate,
		dt.dateTypeID,
		dt.datePoints,
		d.dateDetail,
		day(d.memberDate) as 'Day',
		month(d.memberDate) as 'Month',
		year(d.memberDate) as 'Year'
	from
		memberDates d
		inner join members m on m.memberID = d.memberID_fk
		inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
	where
		{$where}
	order by
		year(d.memberDate) desc,
		month(d.memberDate) desc,
		day(d.memberDate) desc,
		dt.datePoints,
		dt.dateType;";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
