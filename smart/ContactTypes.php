<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('data_library.php');
class ContactTypes {
  function __construct() {}
  public function doFetch($args = NULL) {
	$rows = array();
	$data = New DataLibrary();
	$sql = "select * from contactTypes;";
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
		'contactTypeID'	=> $row['contactTypeID'],
		'contactType'		=> $row['contactType'],
		'active'		=> $row['active']
	  );
	}
	$result->closeCursor();
	unset($response);
	return json_encode($rows);
  }
}
$argsIN = $_POST;
$Foo = New ContactTypes();
echo $Foo->doFetch($argsIN);
?>
