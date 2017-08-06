<?php
require_once('data_library.php');
class MemberContact {
	function __construct() {
	}
	public function doFetch($args = NULL) {
		$rows = array();
		$data = New DataLibrary();
		$memberID = '0';
		if(isset($args['memberID'])) {
			$memberID = ($args['memberID'] > 0) ? $args['memberID'] : NULL;
		}
		$sql = "select * from memberContacts where memberID_fk = $memberID;";
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
				'memberContactID'	=> $row['memberContactID'],
				'memberID_fk'		=> $row['memberID_fk'],
				'contactTypeID_fk'	=> $row['contactTypeID_fk'],
				'memberContact'		=> $row['memberContact'],
				'contactDetail'		=> $row['contactDetail'],
				'lastChangeDate'	=> $row['lastChangeDate']
			);
		}
		$result->closeCursor();
		unset($response);
		return json_encode($rows);
		}
	}
$Foo = New MemberContact();
echo $Foo->doFetch($_POST);
?>
