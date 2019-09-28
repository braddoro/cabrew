<?php
require_once('../shared/Reporter.php');
$wheres = '';
$eventID = (isset($_GET['e'])) ? intval($_GET['e']) : 7;
if(isset($_GET['e'])){
	$wheres .= ' and (C.eventTypeID = ' . intval($_GET['e']) . ') ';
}else{
	$wheres .= " and (C.eventTypeID = {$eventID}) ";
}
// if(isset($_GET['m'])){
// 	$wheres .= ' and (C.memberID = ' . intval($_GET['m']) . ') ';
// 	// $wheres .= ' and C.memberID in (201,57,222) ';
// }
// if(isset($_GET['c'])){
// 	$wheres .= " and (C.status not in ('complete', 'not needed') or C.status is null) ";
// }

// Get a custom title.
//
$params['bind'] = array();
$params['ini_file'] = '../shared/server.ini';
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
$params['bind'] = array(eventTypeID => $eventID);
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = false;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = $title;
$params['sql'] = "select
	C.dueDate,
	case isnull(C.stepURL)
    when true then C.step
	else
    concat('<a href=\"', C.stepURL ,'\" target=\"_blank\">', C.step , '</a>')
	end as Event,
	C.cost,
    C.notes
from eventPlans C
	left join members M on M.memberID = C.memberID
	where eventTypeID = :eventTypeID
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
<link rel="stylesheet" type"text/css" href="../reporter.css">
</head>
<body>
<?php echo $html; ?>
</body>
</html>
