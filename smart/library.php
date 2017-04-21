<?php
function string2array($array){
	$string = '/* ' . PHP_EOL;
	foreach($array as $field => $value){
		$string .= "{$field}: {$value}" . PHP_EOL;
	}
	$string .= ' */' . PHP_EOL;
	return $string;
}
function parseArray($inArr) {
	$outStr = null;
	foreach($inArr as $key => $element) {
		if(!is_array($element)){
			$outStr .= $key . ' | ' . $element . "<br />";
		}else{
			$outStr .= parseArray($element);
		}
	}
	return $outStr;
}
function generateGUID() {
	if (function_exists('com_create_guid')){
		return com_create_guid();
	}else{
		mt_srand((double)microtime()*10000);
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);// "-"
		////chr(123)// "{"
		$uuid = substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12);
			//.chr(125);// "}"
		return $uuid;
	}
}
?>
