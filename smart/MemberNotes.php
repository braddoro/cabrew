<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('data_library.php');
class MemberNote {
  function __construct() {
  }
  public function doFetch($args = NULL) {
	$rows = array();
	$data = New DataLibrary();
	if(isset($args['memberID'])) {
	  $memberID = ($args['memberID'] > 0) ? $args['memberID'] : NULL;
	}else{
	  $memberID = '0';
	}
	$sql = "select * from memberNotes where memberID_fk = $memberID;";
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
		'memberNoteID'		=> $row['memberNoteID'],
		'memberID_fk'		=> $row['memberID_fk'],
		'noteTypeID_fk'		=> $row['noteTypeID_fk'],
		'noteDate'			=> $row['noteDate'],
		'memberNote'		=> $row['memberNote'],
		'lastChangeDate'	=> $row['lastChangeDate']
	  );
	}
	$result->closeCursor();
	unset($response);
	return json_encode($rows);
  }
}

$dbug = "/* POST:" . PHP_EOL;
foreach($_POST as $var => $value) {
  $argsIN[$var] = $value;
  $dbug .= "$var: $value" . PHP_EOL;
}
$dbug .= "*/" . PHP_EOL;
echo $dbug;

$Foo = New MemberNote();
echo $Foo->doFetch($argsIN);
?>
