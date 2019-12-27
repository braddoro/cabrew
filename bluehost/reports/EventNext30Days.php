<?php
require_once('../shared/Reporter.php');

$days = 30;
if(isset($_GET['d'])){
	$days = intval($_GET['d']);
}
$date = new DateTime(date("Y-m-d"));
$date->add(new DateInterval("P{$days}D"));
$tomorrow = $date->format('Y-m-d 11:59:59');

$eventTypeID = 0;
if(isset($_GET['e'])){
	$eventTypeID = intval($_GET['e']);
}

$where = "";
if(isset($_GET['m'])){
	$memberID = intval($_GET['m']);
	$where = 'and C.memberID = ' . $memberID;
}

$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['maintitle'] = 'Cabarrus Homebrewers Society';
$params['title'] = "Todo Next {$days} Days";
$params['bind'] = array('tomorrow' => $tomorrow, 'eventTypeID' => $eventTypeID);
$params['sql'] = "
select
	CT.eventType,
	C.step,
	C.dueDate,
	CONCAT(M.firstName, ' ',M.lastName) AS 'Assignee',
	C.cost,
	C.status,
    C.notes
from eventPlans C
	inner join eventTypes CT on C.eventTypeID = CT.eventTypeID
	left join members M on C.memberID = M.memberID
where
	(C.status IS NULL or (C.status <> 'complete' and C.status <> 'not needed'))
	and C.dueDate <= :tomorrow
	and C.eventTypeID = :eventTypeID
	{$where}
order by
	C.dueDate,
	C.step;";
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="../reporter.css">
</head>
<body>
<?php echo $html; ?>
</body>
</html>
