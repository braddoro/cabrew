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

$detail = 0;
if(isset($_GET['d'])){
	$detail = intval($_GET['d']);
}
require_once('../shared/Reporter.php');
$params['ini_file'] = '../shared/server.ini';
$params['bind'] = array("eventID" => $eventTypeID, "detail" => $detail);
$params['show_total'] = false;
$params['maintitle'] = $mainTitle;
$params['title'] = "{$title} Event Schedule";
$params['sql'] = "SELECT
TIME_FORMAT(stepStart, '%h:%i %p') Start,
TIME_FORMAT(stepEnd, '%h:%i %p') End,
step as Event
FROM eventSchedules
where eventID = :eventID
and typeID >= :detail
order by stepStart, step;";
$lclass = New Reporter();
$html .= $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<meta http-equiv="refresh" content="60">
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="../reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
