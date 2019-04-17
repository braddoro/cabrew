<?php
require_once('../Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../server.ini';
$params['show_total'] = true;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = "Club Meeting Attendance Detail";
$params['sql'] = "
select concat(year(memberDate),'-',lpad(month(memberDate),2,'0')) as Date, count(*) as Total from memberDates
where dateTypeID_fk = 6
group by concat(year(memberDate),'-',lpad(month(memberDate),2,'0'))
order by concat(year(memberDate),'-',lpad(month(memberDate),2,'0'));";
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
<?php echo $html;?>
</body>
</html>
