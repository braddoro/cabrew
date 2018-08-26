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
	left join brew_contacts contact on club.clubID = contact.clubID
	left join brew_contactPoints points on contact.contactID = points.contactID
	left join contactTypes cp on points.contactTypeID_fk = cp.contactTypeID
	left join brew_media media on club.clubID = media.clubID
	left join contactTypes cp2 on media.contactTypeID_fk = cp2.contactTypeID
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
<link rel="stylesheet" type"text/css" href="reporter.css">
</head>
<body>
<?php echo $html; ?>
</body>
</html>
