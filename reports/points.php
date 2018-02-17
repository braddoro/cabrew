<!DOCTYPE html>
<html>
<body>
<head>
<title>Tasks</title>
<link rel="stylesheet" type"text/css" href="../lib/reporter.css">
</head>
<body>
<?php
$year = 2018;
$html = '';
require_once('../lib/Reporter.php');
$params['bind'] = array(year => $year);
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['title'] = "Member Point Totals for {$year}";
$params['sql'] = "
		select
			M.memberID,
			REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ') as 'FullName',
			sum(dt.datePoints) as 'Points'
		from
			memberDates d
			inner join members M on M.memberID = d.memberID_fk
			inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
		where
			year(d.memberDate) = :year
			and M.statusTypeID_fk = 1
		group by
			M.memberID,
			REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ')
		order by
			sum(dt.datePoints) desc,
			REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ');
	";
$lclass = New Reporter();
$html .= $lclass->init($params);
echo $html;
?>
</body>
</html>
