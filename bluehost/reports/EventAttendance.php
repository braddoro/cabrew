<?php
$title = 'Club Event Attendence';
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}else{
	$year = date('Y');
}
if(isset($_GET['e'])){
	$eventID = intval($_GET['e']);
}else{
	$eventID = 6;
}

require_once('../shared/Reporter.php');
$params['ini_file'] = '../shared/server.ini';
$params['bind'] = array('eventID' => $eventID);
$params['show_total'] = false;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = "NCHI {$year} Summary";
$params['sql'] = "
SELECT
	count(*) as 'Clubs Attending'
FROM brew_clubs c
left join brew_attendence a on c.clubID = a.clubID
where a.eventTypeID = :eventID
and a.interested = 'Y'
group by
	a.interested;";
$lclass = New Reporter();
$html = $lclass->init($params);

unset($params['maintitle']);

$params['bind'] = array('eventID' => $eventID);
$params['show_total'] = false;
$params['title'] = "NCHI {$year} Tent Map";
$params['sql'] = "
SELECT
	ba.tentSpace,
	c.clubAbbr,
	c.clubName,
	concat(c.city,', ',c.state) 'Location'
FROM brew_clubs c
left join brew_attendence ba on c.clubID = ba.clubID
left join (
	select
		bab.clubID,
		sum(if(bab.participated = 'Y',1,0)) participated
	from
		brew_attendence bab
	group by
		bab.clubID) pat on c.clubID = pat.clubID
where ba.eventTypeID = :eventID
and ba.invited = 'Y'
and ba.interested = 'Y'
order by ba.tentSpace;";
$lclass = New Reporter();
$html .= $lclass->init($params);


$params['bind'] = array('eventID' => $eventID);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Confirmed Clubs";
$params['sql'] = "
SELECT
	c.clubName,
	c.clubAbbr,
	concat(c.city,', ',c.state) 'Location',
	ba.contact,
	c.distance,
	pat.participated as 'Years',
	ba.kegList,
	ba.tentSpace,
	ba.amtPaid
FROM brew_clubs c
left join brew_attendence ba on c.clubID = ba.clubID
left join (
	select
		bab.clubID,
		sum(if(bab.participated = 'Y',1,0)) participated
	from
		brew_attendence bab
	group by
		bab.clubID) pat on c.clubID = pat.clubID
where ba.eventTypeID = :eventID
and ba.invited = 'Y'
and ba.interested = 'Y'
order by pat.participated desc, c.clubName;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['bind'] = array('eventID' => $eventID);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Undecided Clubs";
// ba.interested as 'Reserved'
$params['sql'] = "
SELECT
	c.clubName,
	c.clubAbbr,
	concat(c.city,', ',c.state) 'Location',
	ba.contact,
	c.distance,
	ba.verified,
	ba.interested
FROM brew_clubs c
left join brew_attendence ba on c.clubID = ba.clubID
where ba.eventTypeID = :eventID
and ba.invited = 'Y'
and (ba.interested <> 'Y' and ba.interested <> 'N')
order by
	ba.interested desc,
    c.distance,
    c.clubName;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['bind'] = array('eventID' => $eventID);
$params['show_total'] = true;
$params['title'] = "NCHI {$year} Declined Clubs";
// ba.interested as 'Reserved'
$params['sql'] = "
SELECT
	c.clubName,
	c.clubAbbr,
	concat(c.city,', ',c.state) 'Location',
	ba.contact,
	c.distance,
	ba.verified
FROM brew_clubs c
left join brew_attendence ba on c.clubID = ba.clubID
where ba.eventTypeID = :eventID
and ba.invited = 'Y'
and ba.interested = 'N'
order by
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

// $params['bind'] = array('year' => $year);
// $params['show_total'] = true;
// $params['title'] = "NCHI {$year} Contact Info";
// //  'facebook'
// $params['sql'] = "
// SELECT
// 	c.clubName,
// 	c.clubAbbr,
// 	concat(c.city,', ',c.state) 'Location',
// 	c.distance,
//     ba.verified,
// 	ba.interested as 'Reserved',
//     bc.contactName,
//     cp.contactPoint
// FROM brew_clubs c
// left join brew_attendence ba on c.clubID = ba.clubID
// left join brew_contacts bc on c.clubID = bc.clubID
// left join brew_contactPoints cp on bc.contactID = cp.contactID
// left join contactTypes ct1 on cp.contactTypeID_fk = ct1.contactTypeID
// where year = :year
// 	and ct1.contactType in ('nchi', 'facebook')
// order by
// 	ba.verified desc,
// 	ba.interested desc,
//     c.distance,
//     c.clubName;";
// $lclass = New Reporter();
// $html .= $lclass->init($params);

// $params['bind'] = array('year' => $year);
// $params['show_total'] = true;
// $params['title'] = "NCHI {$year} Confirmed Club RAW Email Addresses";
// $params['sql'] = "
// SELECT
// 	concat(cp.contactPoint, ', ') 'email'
// FROM brew_clubs c
// left join brew_attendence ba on c.clubID = ba.clubID
// left join brew_contacts bc on c.clubID = bc.clubID
// left join brew_contactPoints cp on bc.contactID = cp.contactID
// left join contactTypes ct1 on cp.contactTypeID_fk = ct1.contactTypeID
// where
// 	ba.year = :year
// 	and ba.interested = 'Y'
// 	and ct1.contactType = 'nchi'
// order by
// 	cp.contactPoint;";
// $lclass = New Reporter();
// $html .= $lclass->init($params);

// $params['bind'] = array('year' => $year);
// $params['show_total'] = true;
// $params['title'] = "NCHI {$year} Unconfirmed Club RAW Email Addresses";
// $params['sql'] = "
// SELECT
// 	concat(cp.contactPoint, ', ') 'email'
// FROM brew_clubs c
// left join brew_attendence ba on c.clubID = ba.clubID
// left join brew_contacts bc on c.clubID = bc.clubID
// left join brew_contactPoints cp on bc.contactID = cp.contactID
// left join contactTypes ct1 on cp.contactTypeID_fk = ct1.contactTypeID
// where
// 	ba.year = :year
// 	and ba.interested = 'N'
// 	and ct1.contactType = 'nchi'
// order by
// 	cp.contactPoint;";
// $lclass = New Reporter();
// $html .= $lclass->init($params);

?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $title ?></title>
<link rel="stylesheet" type"text/css" href="../reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
