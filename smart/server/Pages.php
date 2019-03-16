<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$userID = (isset($_REQUEST['userID'])) ? $_REQUEST['userID'] : -1;
$sql = "select
si.itemName
from sec_users su
inner join sec_user_groups sug on su.secUserID = sug.secUserID
inner join sec_groups sg on sug.secUserGroupID = sg.secGroupID
inner join sec_item_groups sig on sg.secGroupID = sig.secGroupID
inner join sec_items si on sig.secItemID = si.secItemID
where su.active = 'Y'
and sg.active = 'Y'
and si.active = 'Y'
and su.secUserID = {$userID};";
$response = $db->getAll($sql);
echo json_encode($response);
$db->close();
?>
