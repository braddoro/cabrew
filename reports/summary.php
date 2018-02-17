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
$params['title'] = "Club Summary Activity for {$year}";
$params['sql'] = "
	select
		year(md.memberDate) 'Year',
		DATE_FORMAT(md.memberDate, '%M') 'Month',
		dt.dateType,
		count(*) 'Total'
	from
		memberDates md
	inner join
		dateTypes dt on md.dateTypeID_fk = dt.dateTypeID
	where year(md.memberDate) = :year
	group by
		year(md.memberDate),
		DATE_FORMAT(md.memberDate, '%M'),
		dt.dateType
	order by
		year(md.memberDate),
		md.memberDate,
		month(md.memberDate),
		dt.dateType;
	";
$lclass = New Reporter();
$html .= $lclass->init($params);
echo $html;
?>
</body>
</html>
