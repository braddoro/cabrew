<?php
$eventID = 1;
if(isset($_GET['e'])){
	$eventID = intval($_GET['e']);
}
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}else{
	$year = date('Y');
}
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array("eventID" => $eventID);
$params['show_total'] = false;
$params['title'] = "NCHI {$year} Schedule of Events";
$params['sql'] = "SELECT
TIME_FORMAT(stepStart, '%h:%i %p') Start,
TIME_FORMAT(stepEnd, '%h:%i %p') End,
step as Event
FROM eventSchedules
where eventID = :eventID
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
<link rel="stylesheet" type"text/css" href="reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
