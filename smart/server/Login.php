<?php
require_once 'Connect.php';
require_once 'SiteLog.php';
$table = 'statusTypes';
$primaryKey = 'statusTypeID';
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

	$where = '1=1';
	if(isset($_REQUEST['active'])){
		$qStr = $db->qStr($_REQUEST['active'], true);
		$where .= " and active = $qStr ";
	}


$arr = array(
	"pageName" => basename(__FILE__),
	"action" => $operationType,
	"tableName" => $table,
	"primaryKeyID" => isset($pkval) ? intval($pkval) : null,
	"primaryKey" => $primaryKey,
	"fieldsVals" => var_export($_REQUEST, true)
);
$r = siteLog($conn, $db, $arr);
$sql = "select * from {$table} where {$where};";
$response = $db->getAll($sql);
if(!$response){
	$response = array();
}
echo json_encode($response);
$db->close();





$argsIN = array_merge($_POST,$_GET);
$server_array  = parse_ini_file('../lib/server.ini',true);
$dbhost = $server_array['database']['hostname'];
$dbuser = $server_array['database']['username'];
$dbpass = $server_array['database']['password'];
$schema = $server_array['database']['dbname'];
$username = $argsIN['USER_NAME'];
$password = $argsIN['PASSWORD'];
$sql = "select * from users where login = '{$username}' and password = '{$password}' and active = 'Y'";
echo("/*" . $sql . "*/");
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$schema);
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n",$mysqli->connect_error);
	exit();
}
if (!$result = $mysqli->query($sql)) {
	echo "Error: " . $mysqli->error . "\n";
	exit();
}
$rows = array();
$line = array();
$record = array();
while ($row = $result->fetch_object()) {
	$record = array();
	foreach($row as $key => $value){
		$line[$key] = $value;
		$record['name'] = $key;
		$record['value'] = $value;
		$record['type'] = 'text';
		//$rows[] = $record;
	}
	$rows[] = $line;
}
$result->free();
$mysqli->close();
echo json_encode($rows)
?>
