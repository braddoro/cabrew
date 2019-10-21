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
$params['bind'] = array('eventID' => $eventTypeID);
$params['title'] = $title . ' Beer Votes';
$params['sql'] = "SELECT
	bl.beerCode,
	bcc.bjcp2015_category as BJCP_Category,
	bs.bjcpCode,
	bs.bjcpStyle,
	bs.styleABBR,
    bl.beerName,
    bl.brewerName,
    bl.abv,
    bc.clubAbbr,
    bl.votes
FROM eventBeers bl
inner join brew_clubs bc on bl.clubID = bc.clubID
inner join bjcp2015_styles bs on bl.bjcp2015styleID_fk = bs.bjcp2015styleID
inner join bjcp2015_categories bcc on bs.bjcp2015_categoryID = bcc.bjcp2015_categoryID
where
	bl.eventID = :eventID
order by
	bl.votes desc,
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
