<?php
function siteLog($conn, $db, $arguments){
	$table = 'siteLog';
	$primaryKey = 'siteLogID';
	$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $arguments);
	//$db1 = $conn->conn();
	$record = $conn->buildRecordset($data);
	return $db->AutoExecute($table, $record, DB_AUTOQUERY_INSERT);
}
?>
