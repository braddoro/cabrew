<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('data_library.php');
class EventYears {
	function __construct() {}
	public function doFetch($args = NULL) {
		$rows = array();
		$data = New DataLibrary();
		$sql = "select distinct year(memberDate) as 'Year' from memberDates where year(memberDate) > 2014 order by memberDate;";
		$response = $data->getData($sql);
		if(!$response['status']) {
			$rows['status'] = -1;
			$rows['errorMessage'] = $data->parseErrors($response['message']);
			$rows['errors'] = $sql;
			return json_encode($rows);
		}
		$result = $response['result'];
		while ($row = $result->fetch()) {
			$rows[] = array('Year'	=> $row['Year']);
		}
		$result->closeCursor();
		unset($response);
		return json_encode($rows);
	}
}
$argsIN = $_POST;
$Foo = New EventYears();
echo $Foo->doFetch($argsIN);
?>
