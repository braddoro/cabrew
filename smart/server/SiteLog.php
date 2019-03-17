<?php
function siteLog($conn, $dbconn, $arguments, $logFlag = false){
	$table = 'siteLog';
	$primaryKey = 'siteLogID';
	// No need to log a fetch really.
	//
	if($arguments['action'] != 'fetch' || $logFlag){
		$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $arguments);
		$record = $conn->buildRecordset($data);
		return $dbconn->AutoExecute($table, $record, DB_AUTOQUERY_INSERT);
	}
}
?>
