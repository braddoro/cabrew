<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
class Server {
	private $conn = '';
	private $hostname = '';
	private $username = '';
	private $password = '';
	private $dbname = '';
	function __construct() {
		$cabrew_array  = parse_ini_file('cabrew.ini',true);
		$this->hostname = $cabrew_array['database']['hostname'];;
		$this->username = $cabrew_array['database']['username'];
		$this->password = $cabrew_array['database']['password'];
		$this->dbname = $cabrew_array['database']['dbname'];
		$this->connect();
	}
	public function connect($params = null) {
 		try{
			$opt = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
				PDO::ATTR_ERRMODE			 => PDO::ERRMODE_EXCEPTION
			];
			$this->conn = new PDO("mysql:host={$this->hostname};dbname={$this->dbname}", $this->username, $this->password, $opt);
 		}
		catch(PDOException $e){
			$return['status'] = -1;
			$return['errorMessage'] = parseArray($e);
			return $return;
		}
		return $this->conn;
	}
}
?>
