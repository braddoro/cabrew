<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$wheres = '';
if(isset($_REQUEST['year'])){
	$wheres .= ' where year(d.memberDate) = ' . intval($_REQUEST['year']);
}
$sql = "select
		M.memberID,
		st.statusType,
		REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ') as 'FullName',
		sum(dt.datePoints) as 'Points'
	from
		memberDates d
		inner join members M on M.memberID = d.memberID_fk
		inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
	    inner join statusTypes st on M.statusTypeID_fk = st.statusTypeID
	$wheres
	group by
		M.memberID,
		st.statusType,
		REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ')
	order by
		sum(dt.datePoints) desc,
		REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ', M.lastName),'  ',' ');";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
?>
