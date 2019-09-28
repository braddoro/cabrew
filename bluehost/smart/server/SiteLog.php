<?php
function siteLog($conn, $dbconn, $arguments, $logFlag = true){
	$table = 'siteLog';
	$primaryKey = 'siteLogID';
	if($arguments['action'] != 'fetch'){
		$data = array(
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'newvals' => $arguments,
			'primaryKey' => $primaryKey,
			'table' => $table);
		$record = $conn->buildRecordset($data);
		return $dbconn->AutoExecute($table, $record, DB_AUTOQUERY_INSERT);
	}
}
?>
