<?php
// http://www.mustbebuilt.co.uk/php/insert-update-and-delete-with-pdo/
// https://phpdelusions.net/pdo
require_once('Server.php');
require_once('library.php');
class DataModel extends Server {
	private $conn = '';
	private $hostname = '';
	private $username = '';
	private $password = '';
	private $dbname = '';
	private $table = '';
	private $pk_col = '';
	public $allowedOperations = array();
	public $status = false;
	public $errorMessage = '';
	function __construct($params = null) {
		try {
			$this->allowedOperations = array('fetch');
			if(isset($params['allowedOperations'])){
				$this->allowedOperations = $params['allowedOperations'];
			}
			if(!isset($params['baseTable'])){
				$this->status = -112;
				$this->errorMessage = 'A necessary setup value for this view is missing: baseTable. ';
				return $this;
			}
			if(!isset($params['pk_col'])){
				$this->status = -112;
				$this->errorMessage = 'A necessary setup value for this view is missing: pk_col.';
				return $this;
			}
			$baseTable = $params['baseTable'];
			$this->table = "`".str_replace("`","``",$baseTable)."`";
			$this->pk_col = $params['pk_col'];
			$serv = New Server();
			$this->conn = $serv->connect();
		}
		catch(PDOException $e){
			$response['response'] = array(
				'status' => -111,
				'errorMessage' => parseArray($e)
				);
			return $response;
		}
	}
	public function pdoFetch($args = NULL) {
		if(!array_keys($this->allowedOperations, $args['operationType'])){
			return array('status' => -4, 'errorMessage' => "This view does not allow {$args['operationType']} operations.");
		}
 		try{
 			$return = array();
			$pkID = (isset($args["{$this->pk_col}"])) ? intval($args["{$this->pk_col}"]) : NULL;
			$binding[":id"] = $pkID;
			$sql = "select * from {$this->table} where {$this->pk_col} = coalesce(:id,{$this->pk_col});";
			if(isset($args['sql'])){
				$sql = $args['sql'];
			}
			$rows = $this->pdoExecute($sql, $binding, $args['operationType'], $pkID);
		}
		catch(PDOException $e){
			$return['status'] = -110;
			$return['errorMessage'] = parseArray($e);
			return $return;
		}
		return $rows;
	}
	public function pdoAdd($args = NULL) {
		$return = array();
		$setFields = array();
		$setValues = array();
		$bindings = array();
		$fields = $args;
		if(!array_keys($this->allowedOperations, $args['operationType'])){
			return array('status' => -4, 'errorMessage' => "This view does not allow {$args['operationType']} operations.");
		}
		try{
			unset($fields['operationType']);
			foreach($fields as $key => $value){
				$setFields[] = "{$key}, ";
				if(is_numeric($value)){
					$setValues[] = "{$value}, ";
				}else{
					$string = $this->conn->quote($value);
					$setValues[] = "{$string}, ";
				}
			}
			$sql = "INSERT INTO {$this->table} (";
			$sql .= implode($setFields) . 'lastChangeDate) ';
			$sql .= 'VALUES (' . implode($setValues) . ' NOW());';
			$rows = $this->pdoExecute($sql, NULL, $args['operationType'], NULL);
		}
		catch(PDOException $e){
			$return['status'] = -110;
			$return['errorMessage'] = parseArray($e);
			return $return;
		}
		return $rows;
	}
	public function pdoUpdate($args = NULL) {
		$return = array();
		$setFields = array();
		$binding = array();
		if(!array_keys($this->allowedOperations, $args['operationType'])){
			return array('status' => -4, 'errorMessage' => "This view does not allow {$args['operationType']} operations.");
		}
		try{
			$pkID = (isset($args["{$this->pk_col}"])) ? intval($args["{$this->pk_col}"]) : 0;
			$fields = $args;
			unset($fields['operationType']);
			unset($fields["{$this->pk_col}"]);
			foreach ($fields as $key => $value){
				$setFields[] = "{$key} = :{$key}";
				$binding[":{$key}"] = $value;
			}
			$sql = "UPDATE {$this->table} SET ".implode(', ', $setFields).", lastChangeDate = NOW() WHERE {$this->pk_col} = {$pkID}";
			$rows = $this->pdoExecute($sql, $binding, $args['operationType'], $pkID);
		}
		catch(PDOException $e){
			$return['status'] = -110;
			$return['errorMessage'] = parseArray($e);
			return $return;
		}
		return $rows;
	}
	public function pdoRemove($args = NULL) {
		$return = array();
		if(!array_keys($this->allowedOperations, $args['operationType'])){
			return array('status' => -4, 'errorMessage' => "This view does not allow {$args['operationType']} operations.");
		}
		try{
			$pkID = (isset($args["{$this->pk_col}"])) ? intval($args["{$this->pk_col}"]) : 0;
			$binding[":id"] = $pkID;
			$sql = "DELETE FROM {$this->table} WHERE {$this->pk_col} = :id";
			$rows = $this->pdoExecute($sql, $binding, $args['operationType'], $pkID);
		}
		catch(PDOException $e){
			$return['status'] = -110;
			$return['errorMessage'] = parseArray($e);
			return $return;
		}
		return $rows;
	}
	function pdoExecute($sql, $binding, $operationType, $pkID = null){
		try{
			$stmt = $this->conn->prepare($sql);
			$stmt->execute($binding);
			if(!$stmt){
				$return['status'] = $stmt->errorCode();
				$return['errorMessage'] = $stmt->errorInfo();
				return $return;
			}
			switch($operationType){
				case 'fetch':
					$result = $stmt->fetchAll();
					$rows = array();
					foreach($result as $row) {
						$line = array();
						foreach($row as $key => $value) {
							$line[$key] = $value;
						}
						$rows[] = $line;
					}
					unset($result);
					$return = $rows;
					break;
				case 'add':
					$pkID = $this->conn->lastInsertId();
					$fetchArgs["{$this->pk_col}"] = $pkID;
					$fetchArgs['operationType'] = 'fetch';
					$return = $this->pdoFetch($fetchArgs);
					break;
				case 'update':
					$fetchArgs["{$this->pk_col}"] = $pkID;
					$fetchArgs['operationType'] = 'fetch';
					$fetchArgs['retOT'] = $operationType;
					$return = $this->pdoFetch($fetchArgs);
					break;
				case 'remove':
					$return = $stmt->rowCount();
					if($return > 0){
						$fetchArgs["{$this->pk_col}"] = $pkID;
						$fetchArgs['operationType'] = 'fetch';
						$return = $this->pdoFetch($fetchArgs);
					}
					break;
				default:
					//
				break;
			}
		}
		catch(PDOException $e){
			$return['status'] = -110;
			$return['errorMessage'] = parseArray($e);
			return $return;
		}
		return $return;
	}
}
?>
