<?php
class Reporter {
	public function init($params = null){
		return $this->reportControl($params);
	}
	private function reportControl($params){

		// Set up the title.
		//
		$title = '';
		if(isset($params['title'])){
			$title = $params['title'];
		}

		// Make sure we have an sql query.
		//
		if(!isset($params['sql'])){
			return 'A necessary setup value for this view is missing: sql.';
		}
		if(!isset($params['bind'])){
			return 'A necessary setup value for this view is missing: bind.';
		}

		// Is there an ini file?
		//
		if(!isset($params['ini_file'])){
			return 'Connection information is not provided.';
		}
		if(isset($params['ini_file'])){
			$ini_file = $params['ini_file'];
			// Is the path right for the ini file?
			//
			if(!file_exists($ini_file)){
				return 'Unable to locate connection information.';
			}
		}

		$show_total = false;
		if(isset($params['show_total'])){
			if(is_bool($params['show_total'])){
				$show_total = (isset($params['show_total'])) ? $params['show_total'] : false;
			}
		}
		$model_params['sql'] = $params['sql'];
		$model_params['bind'] = $params['bind'];
		$model_params['ini_file'] = $ini_file;
		$data = $this->reportModel($model_params);
		if(isset($params['skip_format']) && $params['skip_format'] === true){
			return $data;
		}

		if(isset($params['maintitle'])){
			$view_params['maintitle'] = $params['maintitle'];
		}
		$view_params['title'] = $title;
		$view_params['data'] = $data;
		$view_params['show_total'] = $show_total;
		$html = $this->reportView($view_params);

		return $html;
	}
	private function reportModel($params){
		$server_array = parse_ini_file($params['ini_file'], true);
		$dbhost = $server_array['database']['hostname'];
		$dbuser = $server_array['database']['username'];
		$dbpass = $server_array['database']['password'];
		$schema = $server_array['database']['dbname'];
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false
		];
		$conn = new PDO("mysql:host={$dbhost};dbname={$schema}", $dbuser, $dbpass, $opt);
		$stmt = $conn->prepare($params['sql']);
		$stmt->execute($params['bind']);
		return $stmt;
	}
	private function prettyColumn($baseName){
		$base = $baseName;
		$fmt = '';
		for($x=0;$x<strlen($base);$x++){
			if(ctype_upper(substr($base, $x, 1))){
				if(!ctype_upper(substr($base, $x-1, 1))){
					$fmt .= ' ';
				}
			}
			$fmt .= substr($base, $x, 1);
		}
		return ucfirst(trim($fmt));
	}
	private function reportView($params){
		$out = "";
		$title = $params['title'];
		if(isset($params['maintitle'])){
			$maintitle = $params['maintitle'];
			$out .= "<div class=\"maintitle\">{$maintitle}</div>" . PHP_EOL;
		}
		$out .= "<span class=\"title\">{$title}</span>" . PHP_EOL;
		$out .= "<table class=\"table\">"  . PHP_EOL;
		$loop = 0;
		$stmt = $params['data'];
		while($row = $stmt->fetch()) {
			if($loop === 0){
				$out .= "\t<tr class=\"header\">" . PHP_EOL;
				foreach($row as $col => $val){
					if(substr($col, 0, 1) != '_'){
						$out .= "\t\t<th>" . $this->prettyColumn($col) . "</th>" . PHP_EOL;
					}
				}
				$out .= "\t</tr>" . PHP_EOL;
			}
			$style = ($loop % 2 == 0) ? 'even' : 'odd';
			$out .= "\t<tr class=\"{$style}\">" . PHP_EOL;
			foreach($row as $col => $val){
				if(substr($col, 0, 1) != '_'){
					$out .= "\t\t<td>" . $val . "</td>" . PHP_EOL;
				}
			}
			$out .= "\t</tr>" . PHP_EOL;
			$loop++;
		}
		$out .= "</table>" . PHP_EOL;
		if($params['show_total']) {
			$out .= "<span class=\"tiny\">{$loop}</span>" . PHP_EOL;
		}
		$out .= "<br>" . PHP_EOL;
		return $out;
	}
}
?>
