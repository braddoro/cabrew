<?php
$eventTypeID = 6;
if(isset($_GET['e'])){
	$eventTypeID = intval($_GET['e']);
}
$wheres = '';
if(isset($_GET['m'])){
	$wheres .= ' and (C.memberID = ' . intval($_GET['m']) . ') ';
}
if(isset($_GET['c'])){
	$wheres .= " and (C.done <> 'Y') ";
}

// Get a custom title.
//
require_once('../Reporter.php');
$params['bind'] = array("eventTypeID" => $eventTypeID);
$params['ini_file'] = '../server.ini';
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
$params['ini_file'] = '../server.ini';
$params['show_total'] = true;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = $title . ' Event Schedule';
	// coalesce() as step1,
	// case LENGTH(LTRIM(C.stepURL))
	//    when 0 then C.step
	// else
	//    concat('<a href=\"', C.stepURL ,'\" target=\"_blank\">', C.step , '</a>')
	// end as step,
$params['sql'] = "
select
	C.eventPlanID,
	C.dueDate,
	CONCAT(M.firstName, ' ',M.lastName) AS 'Assignee',
	C.step,
	C.cost,
	C.status,
	C.stepURL,
    C.notes
from eventPlans C
	left join members M on M.memberID = C.memberID
	where C.eventTypeID = :eventTypeID
	{$wheres}
order by
	C.dueDate,
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
