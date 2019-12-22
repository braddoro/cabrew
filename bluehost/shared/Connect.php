<?php
class Connect {
	protected $dbo;
	public function conn() {
		$hostname = gethostname();
			require_once '../adodb5/adodb.inc.php'; // cabrew.org
		$ini_array = parse_ini_file('server.ini', true);
		$hostname = $ini_array['database']['hostname'];
		$username = $ini_array['database']['username'];
		$password = $ini_array['database']['password'];
		$database = $ini_array['database']['dbname'];
		$dbo = ADOnewConnection('mysqli');
		$dbo->setFetchMode(ADODB_FETCH_ASSOC);
		$dbo->connect($hostname, $username, $password, $database);
		$dbo->setCharset('utf8');
		$this->dbo = $dbo;
		return $dbo;
	}
	public function buildRecordset($data) {
		$cols = $this->dbo->metaColumns($data['table']);
		foreach($data['newvals'] as $key => $value){
			if(array_key_exists(strtoupper($key), $cols)){
				$meta = $cols[strtoupper($key)];
				// echo "/* {$key} = {$meta->type} */";
				switch($meta->type){
					case 'timestamp': // Swallow it.
						break;
					case 'decimal':
						$record[$key] = floatval($value);
						break;
					case 'bigint': // Planned fall through.
					case 'int':
						if(!$meta->primary_key){
							$record[$key] = intval($value);
						}
						break;
					case 'datetime':
						$date = date("Y-m-d H:i:s", strtotime($value));
						$record[$key] = $date;
						if(!$meta->not_null && strlen(trim($value)) == 0){
							$record[$key] = 'NULL';
						}
						break;
					case 'time':
						$date = date("H:i:s", strtotime($value));
						$record[$key] = $date;
						if(!$meta->not_null && strlen(trim($value)) == 0){
							$record[$key] = 'NULL';
						}
						break;
					case 'date':
						$date = date("Y-m-d H:i:s", strtotime($value));
						$record[$key] = $date;
						if(!$meta->not_null && strlen(trim($value)) == 0){
							$record[$key] = 'NULL';
						}
						break;
					case 'varchar':
						$record[$key] = substr(trim($value), 0, $meta->max_length);
						if(!$meta->not_null && strlen(trim($value)) == 0){
							$record[$key] = 'NULL';
						}
						// if(!is_null($value)){
						// 	$record[$key] = substr(trim($value), 0, $meta->max_length);
						// 	if(!$meta->not_null && strlen(trim($value)) == 0){
						// 		$record[$key] = 'NULL';
						// 	}
						// }
						break;

					case 'longtext':
						$record[$key] = substr(trim($value), 0, $meta->max_length);
						if(!$meta->not_null && strlen(trim($value)) == 0){
							$record[$key] = 'NULL';
						}
						break;
					default:
						$err = "Unknown column type:\n " .
							$value . '~' .
							$meta->type . '~' .
							$meta->name . '~' .
							$meta->not_null . '~' .
							$meta->primary_key . '~' .
							$meta->max_length . '~' .
							"\n";
						$response = array('status' => -1, 'errorMessage' => $err);
						return $response;
						break;
				}
			}
		}
		$record['lastChangeDate'] = date("Y-m-d H:i:s");
		return $record;
	}
	public function getMessage($errorNumber, $data = null) {
		switch ($errorNumber) {
			case 1:
				$error = "No Primary Key sent on {$data} action.  This is not desirable. F5 is your friend right now.";
				break;
			case 2:
				$error = "Operation types of {$data} are not allowed on this dataset.";
				break;
			default:
				$error = '';
				break;
		}
		return $error;
	}

}
?>
