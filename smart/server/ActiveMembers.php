<?php
require_once('../../data_library.php');
class ActiveMembers {
  function __construct() {}
  public function doFetch() {
	$rows = array();
	$data = New DataLibrary();
	$sql = "
		select
			M.memberID,
			REPLACE(CONCAT(M.firstName,  ' ', IFNULL(M.midName,''),  ' ', M.lastName),'  ',' ') as 'FullName'
		from
			members M
		where
			M.statusTypeID_fk = 1
		order by
			M.firstName,
			M.lastName;";
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
		'memberID'	=> $row['memberID'],
		'FullName'	=> $row['FullName']
	  );
	}
	$result->closeCursor();
	unset($dataSet);
	return json_encode($rows);
  }
}
$argsIN = $_POST;
$Foo = New ActiveMembers();
echo $Foo->doFetch();
?>
