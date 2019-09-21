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
require_once('../Reporter.php');
$params['ini_file'] = '../server.ini';
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';

$params['bind'] = array("eventID" => $eventID);
$params['show_total'] = false;
$params['title'] = "NCHI Beer Total {$year}";
$params['sql'] = "SELECT count(*) as Total FROM eventBeers where eventID = :eventID;";
$lclass = New Reporter();
$html = $lclass->init($params);

unset($params['maintitle']);

$params['title'] = "NCHI Beer Summary by Club for {$year}";
$params['sql'] = "SELECT
	bc.clubAbbr,
	count(*) as Total
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
group by
	bc.clubAbbr
order by
	count(*) desc,
	bc.clubAbbr;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['title'] = "NCHI Beer BJCP Category Summary for {$year}";
$params['sql'] = "SELECT
	bcc.bjcp2015_category,
	count(*) as Total
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
group by
	bcc.bjcp2015_category
order by
	count(*) desc,
	bcc.bjcp2015_category;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['title'] = "NCHI Beer BJCP Style Summary for {$year}";
$params['sql'] = "SELECT
	bs.bjcpStyle,
	count(*) as Total
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
group by
	bs.bjcpStyle
order by
	count(*) desc,
	bs.bjcpStyle;";
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
