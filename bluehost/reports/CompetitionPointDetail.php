<?php
$year = date('Y');
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}
$yearw = ' and year(D.memberDate) = ' . $year . ' ';
require_once('../Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../server.ini';
$params['show_total'] = true;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = "Competition Point Detail for {$year}";
$params['sql'] = "
select
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ') as Name,
    D.memberDate,
    DT.dateType,
	DT.datePoints,
    D.dateDetail
from members M
	inner join memberDates D on M.memberID = D.memberID_fk
	inner join dateTypes DT on D.dateTypeID_fk = DT.dateTypeID
where
	D.dateTypeID_fk in (14,15,16,17,18,34,35,36,37,38,39,40)
    and M.statusTypeID_fk = 1
	{$yearw}
order by
	D.memberDate,
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ');
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
<?php echo $html;?>
</body>
</html>
