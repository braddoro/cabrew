<?php
require_once('../../lib/data_library.php');
class CheckListTypes {
  function __construct() {}
  public function doFetch() {
	$rows = array();
	$data = New DataLibrary();
	$sql = "select * from checklistTypes;";
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
		'checklistTypeID'	=> $row['checklistTypeID'],
		'checklistType'		=> $row['checklistType'],
		'active'			=> $row['active']
	  );
	}
	$result->closeCursor();
	unset($dataSet);
	return json_encode($rows);
  }
}
$argsIN = $_POST;
$Foo = New CheckListTypes();
echo $Foo->doFetch();
?>
