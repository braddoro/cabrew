<?php
require_once('inc/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = 'inc/server.ini';
$params['show_total'] = true;
$params['title'] = 'Pint Flight 2018 Schedule';
$params['sql'] = 'select
	D.phase,
	D.dueDate,
	D.step,
	D.assignee,
	D.status,
	D.notes
from
	bd7rbk520.checklistData D
    inner join checklistTypes T on D.checklistTypeID = T.checklistTypeID
where
	D.checklistTypeID = 2
order by
	T.checklistType,
	D.phase,
    D.dueDate;';
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="reporter.css">
</head>
<body>
<?php echo $html; ?>
</body>
</html>
