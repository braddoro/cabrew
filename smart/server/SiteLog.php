<?php
function siteLog($conn, $db, $arguments){
	$table = 'siteLog';
	$primaryKey = 'siteLogID';
	// No need to log a fetch really.
	//
	if($arguments['action'] != 'fetch'){
		$data = array('table' => $table, 'primaryKey' => $primaryKey, 'newvals' => $arguments);
		$record = $conn->buildRecordset($data);
		return $db->AutoExecute($table, $record, DB_AUTOQUERY_INSERT);
	}
}
?>
