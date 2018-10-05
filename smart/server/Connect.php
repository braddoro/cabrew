<?php
class Connect {
	public function conn() {
		require_once '/home/brad/git/adodb5/adodb.inc.php';
		$ini_array = parse_ini_file('/home/brad/git/cabrew/smart/server.ini', true);
		$hostname = $ini_array['database']['hostname'];
		$username = $ini_array['database']['username'];
		$password = $ini_array['database']['password'];
		$database = $ini_array['database']['dbname'];
		$dbo = ADOnewConnection('mysqli');
		$dbo->setFetchMode(ADODB_FETCH_ASSOC);
		$dbo->connect($hostname, $username, $password, $database);
		return $dbo;
	}
}
?>
