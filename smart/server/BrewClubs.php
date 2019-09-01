<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
$table = 'brew_clubs';
$primaryKey = 'clubID';
$conn = new Connect();
$dbconn = $conn->conn();
if(!$dbconn->isConnected()){
	$response = array('status' => -1, 'errorMessage' => $dbconn->errorMsg());
	echo json_encode($response);
	exit(1);
}
$pkval = (isset($_REQUEST[$primaryKey])) ? intval($_REQUEST[$primaryKey]) : NULL;
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$where = '1=1';
	if(isset($_REQUEST['active'])){
		$qStr = $dbconn->qStr($_REQUEST['active'], true);
		$where .= " and active = $qStr ";
	}
	if(isset($_REQUEST['distance'])){
		$where .= ' and distance <= ' . intval($_REQUEST['distance']);
	}
	if(isset($_REQUEST['clubName'])){
		$qStr = $dbconn->qStr($_REQUEST['clubName'], true);
		$where .= " and clubName like '%" . $qStr . "%' ";
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
	"ip_address" => $_SERVER['REMOTE_ADDR'],
	"pageName" => basename(__FILE__),
	"primaryKey" => $primaryKey,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"tableName" => $table,
	"userID" => (isset($_REQUEST['userID'])) ? intval($_REQUEST['userID']): 0
);
$r = siteLog($conn, $dbconn, $arr);
$sql = "select * from {$table} where {$where};";
$sql = "select
	max(a.year) LastYear,
	c.clubID,
	c.clubName,
	c.clubAbbr,
	c.city,
	c.state,
	c.distance,
	c.active,
	c.lastChangeDate
from brew_clubs c
left join
	brew_attendence a on c.clubID = a.clubID
where
	{$where}
group by
	c.clubID,
	c.clubName,
	c.clubAbbr,
	c.city,
	c.state,
	c.distance,
	c.active,
	c.lastChangeDate
order by
	a.year desc,
    c.clubName;";
$response = $dbconn->getAll($sql);
if(!$response){
	$response = array();
}
$dbconn->close();
echo json_encode($response);
?>
