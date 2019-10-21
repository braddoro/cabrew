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

if(isset($_GET['m'])){
	$id = intval($_GET['m']);
}
$days = 30;
if(isset($_GET['d'])){
	$days = intval($_GET['d']);
}

$params['bind'] = array("eventID" => $eventTypeID);
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['maintitle'] = $mainTitle;
$params['title'] = $title . ' Todo Task Names';
$params['sql'] = "
select m.memberID, m.firstName, m.lastName, count(*)
from eventPlans ep
left join members m
on ep.memberID = m.memberID
where
ep.eventTypeID = :eventID
and ep.done <> 'Y'
group by m.memberID, m.firstName, m.lastName
order by count(*) desc, m.firstName, m.lastName;
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
