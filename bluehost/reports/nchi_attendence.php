<?php
$year = 2018;
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array('year' => $year);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Attendance";
$params['sql'] = "SELECT c.clubName, a.year, a.interested, a.participated
FROM brew_clubs c
left join brew_attendence a on c.clubID = a.clubID
where year = :year
order by c.clubName;";
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
