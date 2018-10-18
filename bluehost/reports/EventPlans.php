<?php
require_once('inc/Reporter.php');
$wheres = '';
$eventID = (isset($_GET['e'])) ? intval($_GET['e']) : 1;
if(isset($_GET['e'])){
	$wheres .= ' and (C.eventTypeID = ' . intval($_GET['e']) . ') ';
}else{
	$wheres .= ' and (C.eventTypeID = 1) ';
}
if(isset($_GET['m'])){
	$wheres .= ' and (C.memberID = ' . intval($_GET['m']) . ') ';
	// $wheres .= ' and C.memberID in (201,57,222) ';
}
if(isset($_GET['c'])){
	$wheres .= " and (C.status not in ('complete', 'not needed') or C.status is null) ";
}

// Get a custom title.
//
$params['bind'] = array();
$params['ini_file'] = 'inc/server.ini';
$params['sql'] = "select coalesce(description,eventType) as eventType from eventTypes where eventTypeID = $eventID;";
$params['skip_format'] = true;
$lclass = New Reporter();
$data = $lclass->init($params);
$title = '';
while($row = $data->fetch()) {
	foreach($row as $col => $val){
		$title = $val;
	}
}

$params = array();
$params['bind'] = array();
$params['ini_file'] = 'inc/server.ini';
$params['show_total'] = true;
$params['title'] = $title . ' Event Schedule';
$params['sql'] = "select
	C.eventPlanID,
	C.step,
	C.dueDate,
	CONCAT(M.firstName, ' ',M.lastName) AS 'Assignee',
	C.cost,
	C.status,
    C.notes
from eventPlans C
	left join members M on M.memberID = C.memberID
	where 1=1
	{$wheres}
order by
	C.dueDate,
	M.lastName;";
$lclass = New Reporter();
$html = $lclass->init($params);
//echo $params['sql'];
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
