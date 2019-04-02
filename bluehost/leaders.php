<?php
require_once('Reporter.php');
$year = date('Y');
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}
$yearw = ' and year(D.memberDate) = ' . $year . ' ';
$params['bind'] = array();
$params['ini_file'] = 'server.ini';
$params['show_total'] = false;
$params['title'] = "Competition Leader Board for {$year}";
$params['sql'] = "
select
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ') as Name,
	sum(DT.datePoints) as Total
from members M
	inner join statusTypes ST on M.statusTypeID_fk = ST.statusTypeID
	inner join memb	erDates D on M.memberID = D.memberID_fk
	inner join dateTypes DT on D.dateTypeID_fk = DT.dateTypeID
where
	D.dateTypeID_fk in (14,16,18,32,33)
    and M.statusTypeID_fk = 1
	{$yearw}
group by
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ')
order by
	sum(DT.datePoints) desc,
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
<link rel="stylesheet" type"text/css" href="reporter.css">
</head>
<body>
<img src="CABREW_Logo_new.png" height="133" width="200"><br/>
<?php echo $html;?>
</body>
</html>
