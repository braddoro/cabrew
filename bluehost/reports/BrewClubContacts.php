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

$active = 'Y';
if(isset($_GET['a'])){
	$active = $_GET['a'];
}
$priority1 = 5;
if(isset($_GET['p1'])){
	$priority1 = intval($_GET['p1']);
}
$priority2 = 5;
if(isset($_GET['p1'])){
	$priority2 = intval($_GET['p2']);
}
$params['bind'] = array('priority1' => $priority1, 'priority2' => $priority2, 'active' => $active);
$params['ini_file'] = '../shared/server.ini';
$params['maintitle'] = $mainTitle;
$params['title'] = 'Brew Club Contacts';
$params['sql'] = "
select distinct
	concat('<a href=\"',media.media,'\" target=\"_blank\">',club.clubName,'</a>') as 'Club',
	club.clubAbbr,
	concat(club.city,', ',club.state) 'Location',
	club.distance,
	contact.priority as ContactPriority,
	contact.contactName,
	points.contactPoint,
	points.priority as PointPriority
from
	brew_clubs club
	left join brew_contacts contact on club.clubID = contact.clubID
	left join brew_contactPoints points on contact.contactID = points.contactID
	left join contactTypes cp on points.contactTypeID_fk = cp.contactTypeID
	left join brew_media media on club.clubID = media.clubID
	left join contactTypes cp2 on media.contactTypeID_fk = cp2.contactTypeID
where
	club.active = :active
	and contact.priority <= :priority1
	and points.priority <= :priority2
order by
	club.distance,
	club.clubName,
	contact.contactName;
";
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="../reporter.css">
</head>
<body>
<?php echo $html; ?>
</body>
</html>
