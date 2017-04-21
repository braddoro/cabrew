<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('data_library.php');
class MemberChair {
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
	$sql = "select * from memberChairs where memberID_fk = $memberID;";
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
		'memberchairID'		=> $row['memberchairID'],
		'memberID_fk'		=> $row['memberID_fk'],
		'chairTypeID_fk'	=> $row['chairTypeID_fk'],
		'dateTypeID_fk'		=> $row['dateTypeID_fk'],
		'chairDate'			=> $row['chairDate'],
		'memberchair'		=> $row['memberchair'],
		'lastChangeDate'	=> $row['lastChangeDate']
	  );
	}
	$result->closeCursor();
	unset($response);
	return json_encode($rows);
  }
}

$argsIN = $_POST;
$Foo = New MemberChair();
echo $Foo->doFetch($argsIN);
?>
