<?php
$member = '';
if(isset($_GET['m'])){
	$member = ' and M.memberID = ' . intval($_GET['m']) . ' ';
}
$type = '';
if(isset($_GET['t'])){
	$type = ' and D.dateTypeID_fk = ' . intval($_GET['t']) . ' ';
}
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}else{
	$year = date('Y');
}
$yearw = ' and year(D.memberDate) = ' . $year . ' ';
if(isset($_GET['a'])){
	$yearw = '';
}
require_once('../Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../server.ini';
$params['show_total'] = true;
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = "Club Activity Detail for {$year}";
$params['sql'] = "
	select
		M.memberID,
		D.dateTypeID_fk,
		REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ') as Name,
		ST.statusType,
		DT.dateType,
		DT.datePoints,
		D.dateDetail
	from members M
		inner join memberDates D on M.memberID = D.memberID_fk
		left join statusTypes ST on M.statusTypeID_fk = ST.statusTypeID
		left join dateTypes DT on D.dateTypeID_fk = DT.dateTypeID
	where
		1=1
		{$yearw}
		{$member}
		{$type}
	order by
		D.memberDate desc,
		M.firstName,
		M.lastName;
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
