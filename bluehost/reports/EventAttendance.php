<?php
$title = 'Club Event Attendence';
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}else{
	$year = date('Y');
}
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array('year' => $year);
$params['show_total'] = false;
$params['title'] = "NCHI {$year} Summary";
$params['sql'] = "
SELECT
	count(*) as 'Clubs Attending'
FROM brew_clubs c
left join brew_attendence a on c.clubID = a.clubID
where year = :year
and a.interested = 'Y'
group by
	a.interested;";
$lclass = New Reporter();
$html = $lclass->init($params);

$params['bind'] = array('year' => $year);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Confirmed Clubs";
$params['sql'] = "
SELECT
	c.clubName,
	concat(c.city,', ',c.state) 'Location'
FROM brew_clubs c
left join brew_attendence ba on c.clubID = ba.clubID
where year = :year
and ba.interested = 'Y'
order by c.clubName;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['bind'] = array('year' => $year);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Invited Club Status";
$params['sql'] = "
SELECT
	c.clubName,
	c.clubAbbr,
	concat(c.city,', ',c.state) 'Location',
	c.distance,
	ba.verified,
	ba.interested as 'Reserved'
FROM brew_clubs c
left join brew_attendence ba on c.clubID = ba.clubID
where year = :year
order by
	ba.verified desc,
	ba.interested desc,
    c.distance,
    c.clubName;";
$lclass = New Reporter();
$html .= $lclass->init($params);


// $params['bind'] = array('year' => $year);
// $params['show_total'] = true;
// $params['title'] = "NCHI {$year} Unconfirmed Club Contacts";
// $params['sql'] = "
// SELECT
// 	c.clubName,
// 	bc.contactName,
// 	cp.contactPoint,
// 	ba.verified
// FROM brew_clubs c
// left join brew_attendence ba on c.clubID = ba.clubID
// left join brew_contacts bc on c.clubID = bc.clubID
// left join brew_contactPoints cp on bc.contactID = cp.contactID
// left join contactTypes ct1 on cp.contactTypeID_fk = ct1.contactTypeID
// where
// 	ba.year = :year
// 	and ba.interested = 'N'
// 	and ct1.contactType in ('nchi', 'facebook')
// order by
// 	c.clubName,
// 	bc.contactName;";
// $lclass = New Reporter();
// $html .= $lclass->init($params);

$params['bind'] = array('year' => $year);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Contact Info";
//  'facebook'
$params['sql'] = "
SELECT
	c.clubName,
	c.clubAbbr,
	concat(c.city,', ',c.state) 'Location',
	c.distance,
    ba.verified,
	ba.interested as 'Reserved',
    bc.contactName,
    cp.contactPoint
FROM brew_clubs c
left join brew_attendence ba on c.clubID = ba.clubID
left join brew_contacts bc on c.clubID = bc.clubID
left join brew_contactPoints cp on bc.contactID = cp.contactID
left join contactTypes ct1 on cp.contactTypeID_fk = ct1.contactTypeID
where year = :year
	and ct1.contactType in ('nchi')
order by
	ba.verified desc,
	ba.interested desc,
    c.distance,
    c.clubName;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['bind'] = array('year' => $year);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Confirmed Club RAW Email Addresses";
$params['sql'] = "
SELECT
	concat(cp.contactPoint, ', ') 'email'
FROM brew_clubs c
left join brew_attendence ba on c.clubID = ba.clubID
left join brew_contacts bc on c.clubID = bc.clubID
left join brew_contactPoints cp on bc.contactID = cp.contactID
left join contactTypes ct1 on cp.contactTypeID_fk = ct1.contactTypeID
where
	ba.year = :year
	and ba.interested = 'Y'
	and ct1.contactType = 'nchi'
order by
	cp.contactPoint;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['bind'] = array('year' => $year);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Unconfirmed Club RAW Email Addresses";
$params['sql'] = "
SELECT
	concat(cp.contactPoint, ', ') 'email'
FROM brew_clubs c
left join brew_attendence ba on c.clubID = ba.clubID
left join brew_contacts bc on c.clubID = bc.clubID
left join brew_contactPoints cp on bc.contactID = cp.contactID
left join contactTypes ct1 on cp.contactTypeID_fk = ct1.contactTypeID
where
	ba.year = :year
	and ba.interested = 'N'
	and ct1.contactType = 'nchi'
order by
	cp.contactPoint;";
$lclass = New Reporter();
$html .= $lclass->init($params);

?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $title ?></title>
<link rel="stylesheet" type"text/css" href="reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
