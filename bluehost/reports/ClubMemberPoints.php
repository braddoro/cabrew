<?php
$year = date('Y');
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}
require_once('../Reporter.php');
$params['bind'] = array(year => $year);
$params['ini_file'] = '../server.ini';
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
		REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ');";
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
