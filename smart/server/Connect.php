<?php
class Connect {
	protected $dbo;
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
		$this->dbo = $dbo;
		return $dbo;
	}
	public function buildRecordset($data) {
		$retval =  array();
		$cols = $this->dbo->metaColumns($data['table']);
		foreach($data['newvals'] as $key => $value){
			if(array_key_exists(strtoupper($key), $cols)){
				$meta = $cols[strtoupper($key)];
				switch($meta->type){
					case 'int':
						if(!$meta->primary_key){
							$record[$key] = intval($value); // $data['newvals'][$key]
						}
						break;
					case 'varchar':
						// $record[$key] = $this->dbo->qStr(substr($value,0,$meta->max_length), false); // $data['newvals'][$key]
						$record[$key] = substr($value,0,$meta->max_length);
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
		$record['lastChangeDate'] = date("Y-m-d H:i:s");
		return $record;
	}
}
?>
