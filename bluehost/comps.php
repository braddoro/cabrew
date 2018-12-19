<?php
$year = 2018;
require_once('reports/inc/Reporter.php');
$params['ini_file'] = 'reports/inc/server.ini';
$params['bind'] = array("eventTypeID" => 7);
$params['show_total'] = true;
$params['title'] = "CABREW Competion Schedule";
$params['sql'] = "

select
	C.dueDate,
	case isnull(C.stepURL)
    when true then C.step
	else
    concat('<a href=\"', C.stepURL ,'\" target=\"_blank\">', C.step , '</a>')
	end as Event,
    C.notes
from eventPlans C
	left join members M on M.memberID = C.memberID
where
	eventTypeID = :eventTypeID
	and C.dueDate > DATE_ADD(CURDATE(), INTERVAL 7 DAY)
order by
	C.dueDate,
	M.lastName;

";
$lclass = New Reporter();
$html .= $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="reports/reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
