<?php
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}else{
	$year = date('Y');
}
require_once('../Reporter.php');
$params['ini_file'] = '../server.ini';
$params['show_total'] = true;
$params['bind'] = array('year' => $year);
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = "Member Attendance for {$year}";
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
<link rel="stylesheet" type"text/css" href="../reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
