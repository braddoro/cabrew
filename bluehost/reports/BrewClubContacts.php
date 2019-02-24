<?php
require_once('../Reporter.php');
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
$params['ini_file'] = '../server.ini';
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
