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
		if(is_array($element)){
			$tempStr = parseArray($element);
		} else {
			$tempStr = $key . ' | ' . $element . "<br />";
		}
		$outStr .= $tempStr;
	}
	return $outStr;
}
function generateGUID() {
	if (function_exists('com_create_guid')){
		return com_create_guid();
	}
	mt_srand((double)microtime()*10000);
	$charid = strtoupper(md5(uniqid(rand(), true)));
	$hyphen = chr(45);
	$uuid = substr($charid, 0, 8).$hyphen
		.substr($charid, 8, 4).$hyphen
		.substr($charid,12, 4).$hyphen
		.substr($charid,16, 4).$hyphen
		.substr($charid,20,12);
	return $uuid;
}
// Calling example
// validateDate('2012-02-28', 'Y-m-d')
function validateDate($date, $format = 'Y-m-d H:i:s'){
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}
?>
