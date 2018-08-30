<?php
class Connect {
	public function conn($params = NULL) {
		require_once '../../../adodb5/adodb.inc.php';
		$ini_array = parse_ini_file('../../lib/server.ini', true);
		$hostname = $ini_array['database']['hostname'];
		$username = $ini_array['database']['username'];
		$password = $ini_array['database']['password'];
		$database = $ini_array['database']['dbname'];
		$db = ADOnewConnection('mysqli');
		$db->setFetchMode(ADODB_FETCH_ASSOC);
		$db->connect($hostname, $username, $password, $database);
		return $db;
	}
}
?>
