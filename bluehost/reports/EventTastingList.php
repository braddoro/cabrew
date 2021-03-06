<?php
require_once('../shared/Reporter.php');
$cabrew_array = parse_ini_file('../smart/cabrew.ini', true);
$mainTitle = $cabrew_array['reports']['default_main_title'];
$eventTypeID = $cabrew_array['reports']['default_event'];
if(isset($_GET['e'])){
	$eventTypeID = intval($_GET['e']);
}

// Get a custom title.
//
$params['ini_file'] = '../shared/server.ini';
$params['bind'] = array("eventID" => $eventTypeID);
$params['sql'] = "select coalesce(description,eventType) as eventType from eventTypes where eventTypeID = :eventID;";
$params['skip_format'] = true;
$lclass = New Reporter();
$data = $lclass->init($params);
$title = '';
while($row = $data->fetch()){
	foreach($row as $col => $val){
		$title = $val;
	}
}
$params = array();

$params['ini_file'] = '../shared/server.ini';
$params['bind'] = array("eventID" => $eventTypeID);
$params['show_total'] = false;
$params['maintitle'] = "{$mainTitle} <br/> {$title}";

$params['title'] = 'Beer Tasting List by BJCP Category';
$params['sql'] = "SELECT
	bl.beerCode,
	bcc.bjcp2015_category as BJCP_Category,
    bl.beerName,
    bl.abv,
    bc.clubAbbr as Tent
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
order by
	bcc.bjcp2015_category,
	bl.beerName,
	bc.clubAbbr;
";
$lclass = New Reporter();
$html .= $lclass->init($params);

unset($params['maintitle']);
$params['title'] = "Beer Tasting List by Style";
$params['sql'] = "SELECT
	bl.beerCode,
	coalesce(bs.styleABBR, bs.bjcpStyle) as Style,
    bl.beerName,
    bl.abv,
    bc.clubAbbr as Tent
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
order by
	coalesce(bs.styleABBR, bs.bjcpStyle),
	bl.beerName,
	bc.clubAbbr;
";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['title'] = "Beer Tasting List by Club";
$params['sql'] = "SELECT
	bl.beerCode,
    bc.clubAbbr as Tent,
	coalesce(bs.styleABBR, bs.bjcpStyle) as Style,
    bl.beerName,
    bl.abv
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
order by
	bc.clubAbbr,
	coalesce(bs.styleABBR, bs.bjcpStyle),
	bl.beerName;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['title'] = "Beer Tasting List by Code";
$params['sql'] = "SELECT
	bl.beerCode,
	bs.bjcpStyle as Style,
    bl.beerName,
	bl.brewerName,
    bc.clubAbbr as Tent
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
order by
	bl.beerCode";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['title'] = "Beer Tasting List All Details";
$params['sql'] = "SELECT
	bl.beerCode,
	bcc.bjcp2015_category as BJCP_Category,
	bs.bjcpCode,
	bs.bjcpStyle,
    bl.beerName,
    bl.brewerName,
    bl.abv,
    bc.clubAbbr as Tent
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
order by
	bc.clubAbbr,
	bcc.bjcp2015_category,
	bs.bjcpStyle,
	bl.beerName;";
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
