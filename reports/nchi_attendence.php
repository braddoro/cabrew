<?php
require_once('../lib/Reporter.php');
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['bind'] = array('year' => 2018);
$params['title'] = 'NCHI Attendance';
$params['sql'] = "
SELECT c.clubName, a.year, a.interested, a.participated
FROM brew_clubs c
left join brew_attendence a
on c.clubID = a.clubID
where year = :year
order by c.clubName
;";
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="../lib/reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
