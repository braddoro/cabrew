<?php
if(isset($_GET['m'])){
	$id = intval($_GET['m']);
}
$days = 30;
if(isset($_GET['d'])){
	$days = intval($_GET['d']);
}
$wheres = '';
if(isset($_GET['e'])){
	$wheres = ' and C.eventTypeID = ' . intval($_GET['e']) . ' ';
}
require_once('../shared/Reporter.php');
$params['bind'] = array();
// if(isset($id)){
// 	$params['bind'] = array();
// }
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['maintitle'] = 'Cabarrus Homebrewers Society';
$params['title'] = "Todo Task Names";
$params['sql'] = "
select m.memberID, m.firstName, m.lastName, count(*)
from eventPlans ep
left join members m
on ep.memberID = m.memberID
where
ep.eventTypeID = 6
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
