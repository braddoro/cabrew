<?php
$year = 2018;
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array();
$params['show_total'] = true;
$params['title'] = "NCHI Event Teams for {$year}";
$params['sql'] = "
select
e.eventDay, et.teamName, e.teamMember,
TIME_FORMAT(e.startTime, '%h:%i %p') Start,
TIME_FORMAT(e.endTime, '%h:%i %p') End,
e.notes
from eventTeams e
inner join eventTeamNames et on e.eventTeamNameID = et.eventTeamNameID
where e.eventID = 1
order by e.eventDay, e.startTime, et.teamName, e.teamMember;
";
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
