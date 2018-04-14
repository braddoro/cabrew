<?php
require_once('../../lib/data_library.php');
class ActiveMembers {
  function __construct() {}
  public function doFetch() {
	$rows = array();
	$data = New DataLibrary();
	$sql = "
		select
			M.memberID,
			REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ') as 'FullName'
		from
			members M
		where
			M.statusTypeID_fk in (1,5)
		order by
			M.firstName,
			M.lastName";
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
