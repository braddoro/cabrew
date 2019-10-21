<?php
require_once('../shared/Reporter.php');
$cabrew_array = parse_ini_file('../smart/cabrew.ini', true);
$mainTitle = $cabrew_array['reports']['default_main_title'];

require_once('../shared/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['maintitle'] = $mainTitle;
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
