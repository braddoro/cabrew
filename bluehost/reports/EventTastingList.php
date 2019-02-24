<?php
$year = 2018;
require_once('../Reporter.php');
$wheres = '';
$eventID = (isset($_GET['e'])) ? intval($_GET['e']) : 1;
if(isset($_GET['e'])){
	$wheres .= ' and (C.eventTypeID = ' . intval($_GET['e']) . ') ';
}else{
	$wheres .= ' and (C.eventTypeID = 1) ';
}
$params['ini_file'] = '../server.ini';
$params['bind'] = array("eventID" => $eventID);
$params['show_total'] = false;
$params['title'] = "NCHI {$year} Beer Tasting List by Style";
$params['sql'] = "SELECT
bl.beerCode, bl.beerName, bl.beerStyle, bl.abv, bc.clubAbbr as Tent
FROM eventBeers bl
inner join brew_clubs bc
on bl.clubID = bc.clubID
where bl.eventID = :eventID
order by bl.beerStyle, bl.beerName, bc.clubAbbr;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['ini_file'] = '../server.ini';
$params['bind'] = array("eventID" => $eventID);
$params['show_total'] = false;
$params['title'] = "NCHI {$year} Beer Tasting List by Club";
$params['sql'] = "SELECT
bl.beerCode, bl.beerName, bl.beerStyle, bl.abv, bc.clubAbbr as Tent
FROM eventBeers bl
inner join brew_clubs bc
on bl.clubID = bc.clubID
where bl.eventID = :eventID
order by bc.clubAbbr, bl.beerStyle, bl.beerName;";
$lclass = New Reporter();
$html .= $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="../reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
