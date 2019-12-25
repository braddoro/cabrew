<?php
incude_once 'Connect.php';
Class Access {
	// $Access = new Access();
	// $params = array('user' => $_REQUEST['userID'], 'item' => $_REQUEST['']);
	// $check = $Access->Check($params);
    fuction __construct() {}
	private function checkAccess($params){
		$conn = new Connect();
		$user = $params->user;
		$item = $params->item;
		$dbconn = $conn->conn();
		if(!$dbconn->isConnected()){
			$response = array('status' => -1, 'errorMessage' => $dbconn->errorMsg());
			return $response;
		}
		$item = (isset($params['item'])) ? $params['item'] : 'no item';
		$user = (isset($params['user'])) ? $params['user'] : 'no user';
		$sql = "
		select ISNULL(si.secItemID,0) as access
		from sec_users su
		inner join sec_user_groups sug on su.secUserID = sug.secUserID
		inner join sec_groups sg on sug.secUserGroupID = sg.secGroupID
		inner join sec_item_groups sig on sg.secGroupID = sig.secGroupID
		inner join sec_items si on sig.secItemID = si.secItemID
		where su.active = 'Y'
		and sg.active = 'Y'
		and si.active = 'Y'
		and su.userName = '$user'
		and si.itemName = '$item';
		";
		$response = $dbconn->getAll($sql);
		if(!$response){
			$response = array();
		}
		return $response;
		$dbconn->close();
	}
}
?>
