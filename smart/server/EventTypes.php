<?php
require_once 'Connect.php';
$table = 'eventTypes';
$primaryKey = 'eventTypeID';
$conn = new Connect();
$db = $conn->conn();
if(!$db->isConnected()){
	echo $db->errorMsg();
}
$operationType = (isset($_REQUEST['operationType'])) ? $_REQUEST['operationType'] : 'fetch';
switch($operationType){
case 'fetch':
	$wheres = '';
	if(isset($_REQUEST['active'])){
		$qStr = $db->qStr($_REQUEST['active'], true);
		$wheres .= " and active = $qStr ";
	}
	$sql = "select * from $table where 1=1 $wheres;";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(-1);
	}
	break;
case 'add':
	$record['eventType'] = $_REQUEST['eventType'];
	if(isset($_REQUEST['description'])){
		$record['description'] = $_REQUEST['description'];
	}
	$db->AutoExecute($table, $record, 'INSERT');
	$sql = "select * from $table where $primaryKey = " . $db->insert_Id();
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
case 'update':
	$cols = $db->metaColumns($table);
	$pksent = true;
	$skipup = false;
	foreach($_REQUEST as $key => $value){
		if(array_key_exists(strtoupper($key), $cols)){
			$meta = $cols[strtoupper($key)];
			switch($meta->type){
				case 'int':
					if(!$meta->primary_key){
						$record[$key] = intval($_REQUEST[$key]);
					}else{
						if ($meta->name == $primaryKey) {
							$pksent = true;
						}
					}
					break;
				case 'varchar':
					$record[$key] = $db->qStr(substr($_REQUEST[$key],0,$meta->max_length), false);
					break;
				default:
					$skipup = true;
					echo "/* Unknown column type:\n ".
						$value . '~' .
						$meta->name . '~' .
						$meta->type . '~' .
						$meta->not_null . '~' .
						$meta->primary_key . '~' .
						$meta->max_length . '~' .
						"*/\n";
					break;
			}
		}
	}
	if(!$pksent){
		$result = array('status' => -1, 'errormessage' => 'No Primary Key sent.');
	}
	$record['lastChangeDate'] = date("Y-m-d H:i:s");
	$where = $primaryKey . ' = ' . $_REQUEST[$primaryKey];
	if(!$skipup){
		$db->AutoExecute($table, $record, DB_AUTOQUERY_UPDATE, $where);
		$sql = "select * from $table where $where";
		$response = $db->getAll($sql);
		if(!$response){
			$response = array('status' => -1, 'errormessage' => $db->errorMsg());
			echo json_encode($response);
			exit(1);
		}
	}
 	break;
case 'remove':
	$where = $primaryKey . ' = ' . $_REQUEST[$primaryKey];
	$sql = "delete from $table where $where";
	$result = $db->execute($sql);
	$sql = "select * from $table where $where";
	$response = $db->getAll($sql);
	if(!$response){
		echo $db->errorMsg();
		exit(1);
	}
	break;
default:
	break;
}
echo json_encode($response);
$db->close();
?>
