<?php
$year = 2018;
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array('year' => $year);
$params['show_total'] = false;
$params['title'] = "NCHI {$year} Summary";
$params['sql'] = "
SELECT
	count(*) as 'Clubs Attending'
FROM brew_clubs c
left join brew_attendence a on c.clubID = a.clubID
where year = :year
and a.interested = 'Y'
group by
	a.interested;";
$lclass = New Reporter();
$html = $lclass->init($params);

$params['bind'] = array('year' => $year);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Attendance Status";
$params['sql'] = "
SELECT
	c.clubName,
	concat(c.city,', ',c.state) 'Location',
	c.distance,
	a.interested
FROM brew_clubs c
left join brew_attendence a on c.clubID = a.clubID
where year = :year
order by c.distance, c.clubName;";
$lclass = New Reporter();
$html .= $lclass->init($params);


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
