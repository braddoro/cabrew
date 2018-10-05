<?php
$type = 1;
if(isset($_GET['t'])){
	$type = intval($_GET['t']);
}
$year = 2018;
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array("eventID" => 1, "type" => $type);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Schedule of Events";
$params['sql'] = "SELECT
TIME_FORMAT(stepStart, '%h:%i %p') Start,
TIME_FORMAT(stepEnd, '%h:%i %p') End,
step as Event
FROM bd7rbk520.eventSteps
where eventID = :eventID
and type >= :type
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
