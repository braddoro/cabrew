<?php
require_once 'Connect.php';
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
$access_array = parse_ini_file('access.ini', true);
$accesslist = $access_array['access'][basename(__FILE__)];
if((!substr_count($accesslist,$operationType))){
	$response = array('status' => -4, 'errorMessage' => $conn->getMessage(2, $operationType));
	echo json_encode($response);
	exit(1);
}
if(($operationType == 'update' || $operationType == 'remove') && is_null($pkval)){
	$response = array('status' => -1, 'errorMessage' => $conn->getMessage(1, $operationType));
	echo json_encode($response);
	exit(1);
}
switch($operationType){
case 'fetch':
	$where = '1=1';
	if(isset($_REQUEST['year'])){
		$where .= ' and year(d.memberDate) = ' . intval($_REQUEST['year']);
	}else{
		$where .= ' and year(d.memberDate) = ' . date('Y');
	}
	if(isset($_REQUEST['memberID_fk'])){
		$where .= " and d.memberID_fk = " . intval($_REQUEST['memberID_fk']);
	}
	if(isset($_REQUEST['dateTypeID_fk'])){
		$where .= " and d.dateTypeID_fk = " . intval($_REQUEST['dateTypeID_fk']);
	}
	if(isset($_REQUEST['statusTypeID_fk'])){
		$where .= " and M.statusTypeID_fk = " . intval($_REQUEST['statusTypeID_fk']);
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
$sql = "select
		M.memberID,
		st.statusType,
		REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ') as 'FullName',
		sum(dt.datePoints) as 'Points'
	from
		memberDates d
		inner join members M on M.memberID = d.memberID_fk
		inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
	    inner join statusTypes st on M.statusTypeID_fk = st.statusTypeID
	where {$where}
	group by
		M.memberID,
		st.statusType,
		REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ')
	order by
		sum(dt.datePoints) desc,
		REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ');";
echo "/* {$sql} */";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();
?>
