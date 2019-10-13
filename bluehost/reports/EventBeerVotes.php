<?php
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}else{
	$year = date('Y');
}
$eventID = 0;
if(isset($_GET['e'])){
	$eventID = intval($_GET['e']);
}
require_once('../shared/Reporter.php');
$params['ini_file'] = '../shared/server.ini';
$params['maintitle'] = 'Cabarrus Homebrewers Society';

$params['title'] = "Event Beer Votes for {$year}";
$params['sql'] = "SELECT
	bl.beerCode,
	bcc.bjcp2015_category as BJCP_Category,
	bs.bjcpCode,
	bs.bjcpStyle,
    bl.beerName,
    bl.brewerName,
    bl.abv,
    bc.clubAbbr,
    bc.votes
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
order by
	bc.votes,
	bc.clubAbbr,
	bcc.bjcp2015_category;
	";
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
