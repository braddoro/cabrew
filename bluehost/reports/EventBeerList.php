<?php
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}else{
	$year = date('Y');
}
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array();
$params['show_total'] = true;
$params['title'] = "NCHI Beer Summary for {$year}";
$params['sql'] = "SELECT b.clubAbbr as Club, count(c.clubID) as Beers FROM brew_attendence a inner join brew_clubs b on a.clubID = b.clubID left join eventBeers c on c.clubID = b.clubID where a.year = 2018 and a.interested = 'Y' group by b.clubAbbr;";
$lclass = New Reporter();
$html = $lclass->init($params);

$params['bind'] = array("eventID" => 1);
$params['show_total'] = true;
$params['title'] = "NCHI Beer List by Club for {$year}";
$params['sql'] = "SELECT bl.eventBeerID, bl.beerCode, bc.clubName, bc.clubAbbr, bl.beerName, bl.beerStyle, bl.brewerName, bl.abv FROM eventBeers bl inner join brew_clubs bc on bl.clubID = bc.clubID where bl.eventID = :eventID order by bc.clubAbbr, bl.brewerName, bl.beerStyle, bl.beerName;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['bind'] = array("eventID" => 1);
$params['show_total'] = false;
$params['title'] = "NCHI Beer Style Summary for {$year}";
$params['sql'] = "select beerstyle, count(*) as Total from eventBeers where eventID = :eventID group by beerstyle order by count(*) desc, beerstyle;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['bind'] = array("eventID" => 1);
$params['show_total'] = true;
$params['title'] = "NCHI Beer List by Style for {$year}";
$params['sql'] = "SELECT bl.eventBeerID, bl.beerCode, bc.clubName, bc.clubAbbr, bl.beerStyle, bl.beerName, bl.brewerName, bl.abv FROM eventBeers bl inner join brew_clubs bc on bl.clubID = bc.clubID where bl.eventID = :eventID order by bl.beerStyle, bl.beerName, bl.brewerName;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$cutoff = 5;
$params['bind'] = array("eventID" => 1, "votes" => $cutoff);
$params['show_total'] = false;
$params['title'] = "NCHI {$year} Voting results of {$cutoff} votes or more";
$params['sql'] = "SELECT
bl.eventBeerID, bl.beerCode, bc.clubName, bc.clubAbbr, bl.beerStyle, bl.beerName, bl.votes, bl.brewerName, bl.abv FROM eventBeers bl inner join brew_clubs bc on bl.clubID = bc.clubID where bl.eventID = :eventID and bl.votes >= :votes order by bl.votes desc, bl.beerStyle, bl.beerName, bl.brewerName;";
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
