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

$wheres = '';
if(isset($_GET['p'])){
	$wheres .= " and C.eventPhaseID = " . intval($_GET['p']);
}
if(isset($_GET['m'])){
	$wheres .= ' andw (C.memberID = ' . intval($_GET['m']) . ') ';
}
if(isset($_GET['c'])){
	$wheres .= " and (C.done <> 'Y') ";
}
// Get a custom title.
//
$params['bind'] = array("eventTypeID" => $eventTypeID);
$params['ini_file'] = '../shared/server.ini';
$params['sql'] = "select coalesce(description,eventType) as eventType from eventTypes where eventTypeID = :eventTypeID;";
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
$params['bind'] = array("eventTypeID" => $eventTypeID);
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['maintitle'] = $mainTitle;
$params['title'] = $title . ' Event Planning';
// coalesce() as step1,
// case LENGTH(LTRIM(C.stepURL))
//    when 0 then C.step
// else
//    concat('<a href=\"', C.stepURL ,'\" target=\"_blank\">', C.step , '</a>')
// end as step,
// C.eventPlanID,
// C.stepURL,
$params['sql'] = "
select
	C.dueDate,
    EP.eventPhase,
	C.status,
	C.cost,
	CONCAT(M.firstName, ' ',M.lastName) AS 'Assignee',
	C.step,
    C.notes
from eventPlans C
left join members M on M.memberID = C.memberID
left join eventPhases EP on EP.eventPhaseID = C.eventPhaseID
where
	C.eventTypeID = :eventTypeID
	{$wheres}
order by
	C.dueDate,
    EP.eventPhase,
	M.lastName;
";
$lclass = New Reporter();
$html = $lclass->init($params);
// echo $params['sql'];
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
