<?php
$eventTypeID = 0;
if(isset($_GET['e'])){
	$eventTypeID = intval($_GET['e']);
}
require_once('../Reporter.php');
$params['ini_file'] = '../server.ini';
$params['bind'] = array("eventTypeID" => $eventTypeID);
$params['show_total'] = false;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = "Event Budget Summary";
$params['sql'] = "SELECT
et.eventType, et.eventBudget,
sum(b.units*b.cost) TotalSpent,
et.eventBudget-sum(b.units*b.cost) Overage,
max(b.lastChangeDate) LastUpdate
FROM eventBudgets b
inner join eventTypes et on et.eventTypeID = b.eventTypeID
where b.eventTypeID = :eventTypeID
and b.status = 'Buy'
group by
et.eventType, et.eventBudget
order by
et.eventType, et.eventBudget;
";
$lclass = New Reporter();
$html = $lclass->init($params);

unset($params['maintitle']);
$params['bind'] = array("eventTypeID" => $eventTypeID);
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
where eventTypeID = :eventTypeID
and status = 'Buy'
order by
itemName;
";
$lclass = New Reporter();
$html .= $lclass->init($params);

$params['bind'] = array("eventTypeID" => $eventTypeID);
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
where eventTypeID = :eventTypeID
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
