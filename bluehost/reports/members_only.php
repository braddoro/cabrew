<?php
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array();
$params['show_total'] = true;
$params['title'] = "Active Club Members Confirmed Added to Members Only";
$params['sql'] = "
select
REPLACE(CONCAT(IFNULL(m.nickName, m.firstName), ' ', m.lastName),'  ',' ') as 'FullName',
ST.statusType as 'Status'
from members 	 m
inner join memberDates d
on m.memberID = d.memberID_fk
inner join statusTypes ST on m.statusTypeID_fk = ST.statusTypeID
where m.statusTypeID_fk in (1,5)
and dateTypeID_fk = 29
order by m.firstName, m.lastName;";
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
<?php echo $html;?>
</body>
</html>
