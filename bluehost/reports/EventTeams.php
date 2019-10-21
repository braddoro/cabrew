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
$params['bind'] = array(eventID => $eventTypeID);
$params['show_total'] = false;
$params['maintitle'] = 'Cabarrus Homebrewers Society';
$params['title'] = $title . ' Event Teams';
$params['sql'] = "
select
	e.eventDay,
	et.teamName,
	IFNULL(e.teamMember,m.FullName) as Member,
	TIME_FORMAT(e.startTime, '%h:%i %p') Start,
	TIME_FORMAT(e.endTime, '%h:%i %p') End,
	m.memberContact,
	e.notes
from eventTeams e
inner join eventTeamNames et on e.eventTeamNameID = et.eventTeamNameID
left join (
	select
    M.memberID,
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', IFNULL(M.midName, ''), ' ', M.lastName),'  ',' ') as 'FullName',
	C.memberContact
	from members M
	left join memberContacts C on C.memberID_fk = M.memberID
	where C.contactTypeID_fk = 1
) m on e.memberID = m.memberID
where e.eventID = :eventID
order by e.eventDay, e.startTime, et.teamName, IFNULL(e.teamMember,m.FullName);
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
<?php echo $html;?>
</body>
</html>
