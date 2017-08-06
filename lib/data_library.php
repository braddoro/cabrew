<?php
class DataLibrary {
	private $hostname = '';
	private $username = '';
	private $password = '';
	private $dbname = '';
	public  $conn = '';
	public  $debugLevel = 0;
	function __construct() {
		$server_array  = parse_ini_file('server.ini', true);
		$this->hostname = $server_array['database']['hostname'];;
		$this->username = $server_array['database']['username'];
		$this->password = $server_array['database']['password'];
		$this->dbname = $server_array['database']['dbname'];
	}

	// GetData
	//
	// http://www.phpro.org/tutorials/Introduction-to-PHP-PDO.html#4.3
	//
	public function getData2($sql) {
		$retArr = array('status' => true, 'result' => null);
		try {
		    $this->conn = new PDO("mysql:host=$this->hostname;dbname=$this->dbname", $this->username, $this->password);
		    $this->conn->setAttribute("PDO::ATTR_ERRMODE", PDO::ERRMODE_EXCEPTION);
		    }
		catch(PDOException $e){
				$retArr['status'] = false;
				$retArr['result'] = $e;
				return $retArr;
			}
		try {
			$retArr['result'] = $this->conn->query($sql);
			if(!$retArr['result']){
				$retArr['status'] = false;
				$retArr['result'] = 'Unable to execute query: '. $sql;
				return $retArr;
			}
			$rows = array();
			$result = $retArr['result'];
			while ($row = $result->fetch()) {
				$line = array();
				foreach ($row as $key => $value) {
					$line[$key] = $value;
				}
				$rows[] = $line;
			}
			$retArr['result'] = $rows;
		}
		catch (PDOException $pe) {
			$retArr['status'] = false;
			$retArr['result'] = $pe;
			return $retArr;
		}
		return $retArr;
	}

	// getData() Old way, should go away.
	// This whole library is fucked.
	//
	public function getData($sql) {
		$retArr = array('status' => true, 'result' => null, 'message' => array());

		try {
		    $conn = new PDO("mysql:host=$this->hostname;dbname=$this->dbname", $this->username, $this->password);
		    }
		catch(PDOException $e)
		    {
				$retArr['status'] = false;
				$retArr['message'][] = 'Failed to connect.';
				$retArr['message'][] = $e->getMessage();
				$retArr['message'][] = $conn;
				$retArr['message'][] = 'Error Code: ' . $e->getCode();
				$retArr['message'][] = 'Error File: ' . basename($e->getFile());
				$retArr['message'][] = 'Error Line: ' . $e->getLine();
				return $retArr;
				}
		try {
          $retArr['result'] = $conn->query($sql);
		}
		catch (PDOException $pe) {
			$retArr['status'] = false;
			$retArr['message'][] = 'Failed to query.';
			$retArr['message'][] = $pe->getMessage();
			$retArr['message'][] = $sql;
			$retArr['message'][] = 'Error Code: ' . $pe->getCode();
			$retArr['message'][] = 'Error File: ' . basename($pe->getFile());
			$retArr['message'][] = 'Error Line: ' . $pe->getLine();
			return $retArr;
		}

		return $retArr;
	}

	// parseErrors
	//
	public function parseErrors($inArr) {
		$outStr = null;
		foreach($inArr as $key => $element) {
			$outStr .= $key . " - " . $element."<br />";
		}
		return $outStr;
	}
}
?>
