<?php
require_once('../shared/Reporter.php');
$cabrew_array = parse_ini_file('../smart/cabrew.ini', true);
$mainTitle = $cabrew_array['reports']['default_main_title'];
$eventTypeID = $cabrew_array['reports']['default_event'];
if(isset($_GET['e'])){
	$eventTypeID = intval($_GET['e']);
}

// Get a custom title.
//
$params['ini_file'] = '../shared/server.ini';
$params['bind'] = array("eventID" => $eventTypeID);
$params['sql'] = "select coalesce(description,eventType) as eventType from eventTypes where eventTypeID = :eventID;";
$params['skip_format'] = true;
$lclass = New Reporter();
$data = $lclass->init($params);
$title = '';
while($row = $data->fetch()){
	foreach($row as $col => $val){
		$title = $val;
	}
}
$params = array();

if(isset($_GET['m'])){
	$id = intval($_GET['m']);
}
$days = 30;
if(isset($_GET['d'])){
	$days = intval($_GET['d']);
}
$wheres = '';

$params['bind'] = array('id' => NULL);
if(isset($id)){
	$params['bind'] = array('id' => $id);
}
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['maintitle'] = $mainTitle;
$params['title'] = "{$title} Todo Next {$days} Days";
$params['sql'] = "
select
	CONCAT(M.firstName, ' ',M.lastName) AS 'Assignee',
	C.dueDate,
	C.step,
	C.cost,
    C.notes
from eventPlans C
	inner join eventTypes CT on C.eventTypeID = CT.eventTypeID and CT.active = 'Y'
	left join members M on M.memberID = C.memberID
where (C.status IS NULL or (C.status <> 'complete' and C.status <> 'not needed'))
	and C.dueDate < DATE_ADD(CURDATE(), INTERVAL {$days} DAY)
	and C.memberID = coalesce(:id, C.memberID)
	$wheres
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
