<?php
require_once('inc/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = 'inc/server.ini';
$params['show_total'] = true;
$params['title'] = 'Todo Next 30 Days';
$params['sql'] = "
select
	CT.checklistType,
	C.step,
	C.dueDate,
	CONCAT(M.firstName, ' ',M.lastName) AS 'Assignee',
	C.cost,
	C.status,
    C.notes
from checklistData C
	left join members M on M.memberID = C.memberID_fk
	left join checklistTypes CT on C.checklistTypeID = CT.checklistTypeID
where (C.status IS NULL OR  C.status <> 'complete')
	and C.dueDate < DATE_ADD(CURDATE(), INTERVAL 35 DAY)
order by
	C.dueDate;";
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
