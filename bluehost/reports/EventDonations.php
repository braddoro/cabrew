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
$params['bind'] = array("eventTypeID" => $eventTypeID);
$params['show_total'] = false;
$params['maintitle'] = $mainTitle;
$params['title'] = "{$title} Event Donations";
$params['sql'] = "
select
	cd.status,
	en.entityName,
	en.entityType,
	cd.notes
from corporateDonations cd
inner join entityNames en on cd.entityNameID_fk = en.entityNameID
where cd.eventTypeID_fk = :eventTypeID
order by
	cd.status,
	en.entityName;";
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo 'Event Budget' ?></title>
<link rel="stylesheet" type"text/css" href="../reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
