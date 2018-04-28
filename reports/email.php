<?php
require_once('../lib/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['title'] = 'Other Club Email List';
$params['sql'] = "
	select
		CONCAT(points.contactPoint, ', ') as email
	from
		brew_clubs club
		inner join brew_contacts contact on club.clubID = contact.clubID
		inner join brew_contactPoints points on contact.contactID = points.contactID
		inner join contactTypes cp on points.contactTypeID_fk = cp.contactTypeID
	where
		points.contactTypeID_fk = 2
		and contact.priority = 1
	order by
		club.clubName,
		club.clubAbbr,
		contact.contactName,
		cp.contactType;
	";
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="../lib/reporter.css">
</head>
<body>
<?php echo $html; ?>
</body>
</html>
