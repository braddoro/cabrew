<?php
require_once('../../lib/data_library.php');
class MemberList {
  function __construct() {}
  public function doFetch() {
	$rows = array();
	$data = New DataLibrary();
	$sql = "
		select
			M.memberID,
			REPLACE(CONCAT(IFNULL(m.nickName,m.firstName), ' ', m.lastName),'  ',' ') as 'FullName',
			MS.statusType
		from
			members M
		inner join statusTypes MS on M.statusTypeID_fk = MS.statusTypeID
		order by
			M.lastName,
			M.firstName;";
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
		'memberID'	 => $row['memberID'],
		'FullName'	 => $row['FullName'],
		'StatusType' => $row['statusType']
	  );
	}
	$result->closeCursor();
	unset($dataSet);
	return json_encode($rows);
  }
}
$argsIN = $_POST;
$Foo = New MemberList();
echo $Foo->doFetch();
?>
