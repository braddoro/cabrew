<?php
require_once('../../lib/data_library.php');
class ContactTypes {
  function __construct() {}
  public function doFetch() {
	$rows = array();
	$data = New DataLibrary();
	$sql = "select * from contactTypes;";
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
		'contactTypeID'	=> $row['contactTypeID'],
		'contactType'	=> $row['contactType'],
		'active'		=> $row['active']
	  );
	}
	$result->closeCursor();
	unset($dataSet);
	return json_encode($rows);
  }
}
$argsIN = $_POST;
$Foo = New ContactTypes();
echo $Foo->doFetch();
?>
