<?php
require_once 'Connect.php';
$conn = new Connect();
$db = $conn->conn();
$wheres = '';
if(isset($_REQUEST['memberID'])) {
	$wheres .= ' and m.memberID = ' . intval($_REQUEST['memberID']);
}
if(isset($_REQUEST['year'])) {
	$wheres .= ' and year(d.memberDate) = ' . intval($_REQUEST['year']);
}
$sql = "select
		m.memberID,
		d.memberDate,
		dt.dateTypeID,
		dt.datePoints,
		d.dateDetail,
		day(d.memberDate) as 'Day',
		month(d.memberDate) as 'Month',
		year(d.memberDate) as 'Year'
	from
		memberDates d
		inner join members m on m.memberID = d.memberID_fk
		inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
	where
		dt.datePoints > 0
		{$wheres}
	order by
		year(d.memberDate) desc,
		month(d.memberDate) desc,
		day(d.memberDate) desc,
		dt.datePoints,
		dt.dateType;";
$response = $db->getAll($sql);
if($response){
	echo json_encode($response);
}else{
	echo $db->errorMsg();
}
$db->close();
?>
