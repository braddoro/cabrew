<?php
require_once('../../lib/data_library.php');
class EventYears {
	function __construct() {}
	public function doFetch() {
		$rows = array();
		$data = New DataLibrary();
		$sql = "select distinct year(memberDate) as 'Year' from memberDates where year(memberDate) > 2014 order by memberDate;";
		$dataSet = $data->getData($sql);
		if(!$dataSet['status']) {
			$rows['status'] = -1;
			$rows['errorMessage'] = $data->parseErrors($dataSet['message']);
			$rows['errors'] = $sql;
			return json_encode($rows);
		}
		$result = $dataSet['result'];
		while ($row = $result->fetch()) {
			$rows[] = array('Year'	=> $row['Year']);
		}
		$result->closeCursor();
		unset($dataSet);
		return json_encode($rows);
	}
}
$argsIN = $_POST;
$Foo = New EventYears();
echo $Foo->doFetch();
?>
