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
$params['maintitle'] = $mainTitle;

$params['bind'] = array("eventID" => $eventTypeID);
$params['show_total'] = false;
$params['title'] = "NCHI Beer Total {$year}";
$params['sql'] = "SELECT count(*) as Total FROM eventBeers where eventID = :eventID;";
$lclass = New Reporter();
$html = $lclass->init($params);

unset($params['maintitle']);

$params['title'] = "{$title} Beer Summary by Club";
$params['show_total'] = true;
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

$params['title'] = "{$title} BJCP Category Summary";
$params['show_total'] = false;
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

$params['title'] = "{$title} BJCP Style Summary";
$params['sql'] = "SELECT
	bs.bjcpStyle as Style,
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

$params['title'] = "{$title} Summary by Club and Style";
$params['sql'] = "SELECT
	bc.clubAbbr,
	bs.bjcpStyle as Style,
	count(*) as Total
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
group by
	bc.clubAbbr,
	bs.bjcpStyle
order by
	bc.clubAbbr,
	bs.bjcpStyle,
	count(*) desc;
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
