<?php
require_once 'Connect.php';
$table = 'memberDates';
$primaryKey = 'memberDateID';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
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
		dt.datePoints > 1
		and year(d.memberDate) = 2018
	order by
		d.memberDate,
		dt.dateType;";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(-1);
	}
	break;
case 'add':
	$record['memberID_fk'] = $_REQUEST['memberID_fk'];
	$record['dateTypeID_fk'] = $_REQUEST['dateTypeID_fk'];
	$record['memberDate'] = $_REQUEST['memberDate'];
	$record['dateDetail'] = $_REQUEST['dateDetail'];
	$db->AutoExecute($table, $record, 'INSERT');
	echo $db->errorMsg();
	break;
case 'update':
	if(isset($_REQUEST['memberID'])){
		$record['memberID'] = $_REQUEST['memberID'];
	}
	if(isset($_REQUEST['dateTypeID_fk'])){
		$record['dateTypeID_fk'] = $_REQUEST['dateTypeID_fk'];
	}
	if(isset($_REQUEST['memberDate'])){
		$record['memberDate'] = $_REQUEST['memberDate'];
	}
	if(isset($_REQUEST['dateDetail'])){
		$record['dateDetail'] = $_REQUEST['dateDetail'];
	}
	$record['lastChangeDate'] = date("Y-m-d H:i:s");
	$where = $primaryKey . ' = ' . $_REQUEST[$primaryKey];
	$db->AutoExecute($table, $record, 'UPDATE', $where);
	$sql = "select * from $table where $where";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
 	break;
case 'remove':
	$where = $primaryKey . ' = ' . $_REQUEST[$primaryKey];
	$sql = "delete from $table where $where";
	$result = $db->execute($sql);
	$sql = "select * from $table where $where";
	$response = $db->getAll($sql);
	break;
default:
	break;
}
echo json_encode($response);
$db->close();
