<?php
require_once('../lib/Reporter.php');
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['bind'] = array('year' => 2018);
$params['title'] = 'Member Attendance';
$params['sql'] = "
select
	year(D.memberDate) as 'year',
    count(*) as 'meetings',
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ') as 'FullName'
from
	members M
inner join
	memberDates D on M.memberID = D.memberID_fk
where
	M.statusTypeID_fk = 1
	and D.dateTypeID_fk = 6
	and year(D.memberDate) = coalesce(:year,year(D.memberDate))
group by
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' '),
	year(D.memberDate)
order by
	year(D.memberDate) desc,
	count(*) desc,
    REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ')
;";
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo $params['title'] ?></title>
<link rel="stylesheet" type"text/css" href="../lib/reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
