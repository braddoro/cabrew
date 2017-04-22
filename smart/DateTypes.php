<?php
require_once('data_library.php');
class DateTypes {
  function __construct() {}
  public function doFetch() {
	$rows = array();
	$data = New DataLibrary();
	$sql = "select * from dateTypes;";
	$dataSet = $data->getData($sql);
	if(!$dataSet['status']) {
	  $rows['status'] = -1;
	  $rows['errorMessage'] = $data->parseErrors($dataSet['message']);
	  $rows['errors'] = $sql;
	  return json_encode($rows);
	}
	$result = $dataSet['result'];
	while ($row = $result->fetch()) {
		$rows[] = array(
		'dateTypeID'	=> $row['dateTypeID'],
		'dateType'		=> $row['dateType'],
		'active'		=> $row['active'],
		'datePoints'	=> $row['datePoints']
	  );
	}
	$result->closeCursor();
	unset($dataSet);
	return json_encode($rows);
  }
}
$argsIN = $_POST;
$Foo = New DateTypes();
echo $Foo->doFetch();
?>
