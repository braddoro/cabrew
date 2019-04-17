<?php
if(isset($_GET['m'])){
	$id = intval($_GET['m']);
}
$days = 30;
if(isset($_GET['d'])){
	$days = intval($_GET['d']);
}
require_once('../Reporter.php');
$params['bind'] = array(id => NULL);
if(isset($id)){
	$params['bind'] = array(id => $id);
}
$params['ini_file'] = '../server.ini';
$params['show_total'] = true;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = "Todo Next {$days} Days";
$params['sql'] = "
select
	C.eventPlanID,
	CT.eventType,
	C.step,
	C.dueDate,
	CONCAT(M.firstName, ' ',M.lastName) AS 'Assignee',
	C.cost,
	C.status,
    C.notes
from eventPlans C
	inner join eventTypes CT on C.eventTypeID = CT.eventTypeID and CT.active = 'Y'
	left join members M on M.memberID = C.memberID
where (C.status IS NULL or C.status <> 'complete')
	and C.dueDate < DATE_ADD(CURDATE(), INTERVAL {$days} DAY)
	and C.memberID = coalesce(:id, C.memberID)
order by
	C.dueDate;";
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
