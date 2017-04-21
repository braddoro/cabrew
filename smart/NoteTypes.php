<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('data_library.php');
class NoteTypes {
  function __construct() {}
  public function doFetch($args = NULL) {
	$rows = array();
	$data = New DataLibrary();
	$sql = "select * from noteTypes;";
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
		'noteTypeID'	=> $row['noteTypeID'],
		'noteType'		=> $row['noteType'],
		'active'		=> $row['active']
	  );
	}
	$result->closeCursor();
	unset($response);
	return json_encode($rows);
  }
}
$argsIN = $_POST;
$Foo = New NoteTypes();
echo $Foo->doFetch($argsIN);
?>
