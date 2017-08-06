<?php
require_once('../../data_library.php');
class MemberNote {
	function __construct() {
	}
	public function doFetch($args = NULL) {
		$rows = array();
		$data = New DataLibrary();
		$memberID = '0';
		if(isset($args['memberID'])) {
			$memberID = ($args['memberID'] > 0) ? $args['memberID'] : NULL;
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
foreach($_POST as $var => $value) {
	$argsIN[$var] = $value;
}
$Foo = New MemberNote();
echo $Foo->doFetch($argsIN);
?>
