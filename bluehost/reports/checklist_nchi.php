<?php
$member = "";
if(isset($_GET['m'])){
	$member = ' and C.memberID = ' . intval($_GET['m']) . ' ';
}
$todo = "";
if(isset($_GET['c'])){
	$todo = " and (C.status not in ('complete', 'not needed') or C.status is null) ";
}
require_once('inc/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = 'inc/server.ini';
$params['show_total'] = true;
$params['title'] = 'NCHI 2018 Playbook';
$params['sql'] = "
select
	C.eventDataID,
	C.step,
	C.dueDate,
	CONCAT(M.firstName, ' ',M.lastName) AS 'Assignee',
	C.cost,
	C.status,
	C.thread,
    C.notes
from eventData C
	left join members M on M.memberID = C.memberID
where
	C.eventTypeID = 1
	{$member}
	{$todo}
order by
	C.dueDate,
	M.lastName;
	";
//echo $params['sql'];
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="reporter.css">
</head>
<body>
<?php echo $html; ?>
</body>
</html>
