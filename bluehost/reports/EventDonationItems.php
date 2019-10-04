<?php
$eventTypeID = 0;
if(isset($_GET['e'])){
	$eventTypeID = intval($_GET['e']);
}
require_once('../shared/Reporter.php');
$params['ini_file'] = '../shared/server.ini';
$params['bind'] = array("eventTypeID" => $eventTypeID);
$params['show_total'] = false;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = "Event Donations";
// , cd.lastUpdateDate
$params['sql'] = "select
	cd.type,
	cd.donationItem,
	en.entityName
from corporateDonationItems cd
inner join entityNames en on cd.entityNameID = en.entityNameID
where cd.eventTypeID = :eventTypeID
order by
	cd.type,
	cd.donationItem,
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
