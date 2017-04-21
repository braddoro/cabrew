<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('data_library.php');
class DateTypes {
  function __construct() {}
  public function doFetch($args = NULL) {
	$rows = array();
	$data = New DataLibrary();
	$sql = "select * from dateTypes;";
	$response = $data->getData($sql);
	if(!$response['status']) {
	  $rows['status'] = -1;
	  $rows['errorMessage'] = $data->parseErrors($response['message']);
	  $rows['errors'] = $sql;
	  return json_encode($rows);
	}
	$result = $response['result'];
	while ($row = $result->fetch()) {
		$rows[] = array(
		'dateTypeID'	=> $row['dateTypeID'],
		'dateType'		=> $row['dateType'],
		'active'		=> $row['active'],
		'datePoints'	=> $row['datePoints']
	  );
	}
	$result->closeCursor();
	unset($response);
	return json_encode($rows);
  }
}
$argsIN = $_POST;
$Foo = New DateTypes();
echo $Foo->doFetch($argsIN);
?>
