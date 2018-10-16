<?php
$year = 2018;
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array("eventID" => 1);
$params['show_total'] = false;
$params['title'] = "NCHI {$year} Beer Tasting List";
$params['sql'] = "SELECT
bl.beerCode, bl.beerName, bl.beerStyle, bc.clubAbbr as Tent
FROM bd7rbk520.beerList bl
inner join bd7rbk520.brew_clubs bc
on bl.clubID = bc.clubID
where bl.eventID = :eventID
order by bl.beerStyle, bl.beerName, bc.clubAbbr;";
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
