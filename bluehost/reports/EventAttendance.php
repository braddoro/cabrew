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
$params['bind'] = array('eventID' => $eventTypeID);
$params['show_total'] = false;
$params['maintitle'] = $mainTitle;
$params['title'] = $title;
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

$params['bind'] = array('eventID' => $eventTypeID);
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


$params['bind'] = array('eventID' => $eventTypeID);
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

$params['bind'] = array('eventID' => $eventTypeID);
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

$params['bind'] = array('eventID' => $eventTypeID);
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
