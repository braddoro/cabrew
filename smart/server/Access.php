<?php
require_once 'Connect.php';
Class Access {
    function __construct() {}
	private function Check($params){
		$conn = new Connect();
		$user = $params->user;
		$item = $params->item;
		$db = $conn->conn();
		if(!$db->isConnected()){
			$response = array('status' => -1, 'errorMessage' => $db->errorMsg());
			return $response;
		}
		$item = (isset($_REQUEST['item'])) ? $_REQUEST['item'] : 'no item';
		$user = (isset($_REQUEST['user'])) ? $_REQUEST['user'] : 'no user';
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
		$response = $db->getAll($sql);
		if(!$response){
			$response = array();
		}
		return $response;
		$db->close();
	}
}
?>
