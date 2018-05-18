<?php
require_once('inc/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = 'inc/server.ini';

$params['title'] = 'Other Club Contacts';
$params['sql'] = "
select distinct
	concat('<a href=\"',media.media,'\" target=\"_blank\">',club.clubName,'</a>') as 'Club',
	club.clubAbbr,
	concat(club.city,', ',club.state) 'Location',
	club.distance,
	contact.contactName,
	points.contactPoint
from
	brew_clubs club
	inner join brew_contacts contact on club.clubID = contact.clubID
	inner join brew_contactPoints points on contact.contactID = points.contactID
	inner join contactTypes cp on points.contactTypeID_fk = cp.contactTypeID
	inner join brew_media media on club.clubID = media.clubID
	inner join contactTypes cp2 on media.contactTypeID_fk = cp2.contactTypeID
	inner join brew_attendence att on club.clubID = att.clubID
where
	media.priority = 1
    and points.priority = 1
    and points.contactTypeID_fk = 2
    and att.year = 2018
order by
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
<link rel="stylesheet" type"text/css" href="reporter.css">
</head>
<body>
<?php echo $html; ?>
</body>
</html>
