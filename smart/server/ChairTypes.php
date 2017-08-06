<?php
require_once('data_library.php');
class ChairTypes {
  function __construct() {}
  public function doFetch() {
	$rows = array();
	$data = New DataLibrary();
	$sql = "select * from chairTypes;";
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
		'chairTypeID'	=> $row['chairTypeID'],
		'chairType'		=> $row['chairType'],
		'active'		=> $row['active']
	  );
	}
	$result->closeCursor();
	unset($dataSet);
	return json_encode($rows);
  }
}
$argsIN = $_POST;
$Foo = New ChairTypes();
echo $Foo->doFetch();
?>
