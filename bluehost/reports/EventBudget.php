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
$params['bind'] = array("eventID" => $eventTypeID);
$params['show_total'] = false;
$params['maintitle'] = $mainTitle;
$params['title'] = $title . ' Event Budget';
$params['sql'] = "SELECT
et.eventType, et.eventBudget,
sum(b.units*b.cost) TotalSpent,
et.eventBudget-sum(b.units*b.cost) Overage,
max(b.lastChangeDate) LastUpdate
FROM eventBudgets b
inner join eventTypes et on et.eventTypeID = b.eventTypeID
where b.eventTypeID = :eventID
and b.status = 'Buy'
group by
et.eventType, et.eventBudget
order by
et.eventType, et.eventBudget;";
$lclass = New Reporter();
$html = $lclass->init($params);

unset($params['maintitle']);
$params['bind'] = array("eventID" => $eventTypeID);
$params['show_total'] = true;
$params['title'] = "Event Budgeted Items";
$params['sql'] = "SELECT
(units*cost) total,
units,
cost,
source,
owner,
count,
countUnits,
status,
action,
itemName
FROM eventBudgets
where eventTypeID = :eventID
and status = 'Buy'
order by
itemName;";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['bind'] = array("eventID" => $eventTypeID);
$params['show_total'] = true;
$params['title'] = "Event Non-Budgeted Items";
$params['sql'] = "SELECT
(units*cost) total,
units,
cost,
source,
owner,
count,
countUnits,
status,
action,
itemName
FROM eventBudgets
where eventTypeID = :eventID
and status <> 'Buy'
order by
status, action, itemName;";
$lclass = New Reporter();
$html .= $lclass->init($params);
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
