<!DOCTYPE html>
<html>
<body>
<head>
<title>Tasks</title>
<link rel="stylesheet" type"text/css" href="../lib/reporter.css">
</head>
<body>
<?php
$html = '';
require_once('../lib/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['title'] = 'Other Club Contacts';
$params['sql'] = "
	select distinct
		club.clubName,
		club.clubAbbr,
		club.city,
		club.state,
		contact.contactName,
		points.contactPoint,
		cp.contactType,
		concat('<a href=\"',media.media,'\">url</a>') as 'web'
	from
		brew_clubs club
		inner join brew_contacts contact on club.clubID = contact.clubID
		inner join brew_contactPoints points on contact.contactID = points.contactID
		inner join contactTypes cp on points.contactTypeID_fk = cp.contactTypeID
		inner join brew_media media on club.clubID = media.clubID
		inner join contactTypes cp2 on media.contactTypeID_fk = cp2.contactTypeID
	where
		media.contactTypeID_fk = 5
		and points.contactTypeID_fk = 2
		and media.priority = 1
	order by
		club.clubName,
		club.clubAbbr,
		contact.contactName,
		cp.contactType;
	";
$lclass = New Reporter();
$html .= $lclass->init($params);
echo $html;
?>
</body>
</html>
