<?php
$eventID = 1;
if(isset($_GET['e'])){
	$eventID = intval($_GET['e']);
}
$year = date('Y');
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}
$detail = 0;
if(isset($_GET['d'])){
	$detail = intval($_GET['d']);
}
require_once('../shared/Reporter.php');
$params['ini_file'] = '../shared/server.ini';
$params['bind'] = array("eventID" => $eventID, "detail" => $detail);
$params['show_total'] = false;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = "NCHI {$year} Schedule of Events";
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
