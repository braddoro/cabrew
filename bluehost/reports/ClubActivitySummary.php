<?php
require_once('../shared/Reporter.php');
$cabrew_array = parse_ini_file('../smart/cabrew.ini', true);
$mainTitle = $cabrew_array['reports']['default_main_title'];

if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}else{
	$year = date('Y');
}
require_once('../shared/Reporter.php');
$params['bind'] = array(year => $year);
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['maintitle'] = $mainTitle;
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
