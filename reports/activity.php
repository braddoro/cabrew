<?php
require_once('../lib/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['title'] = 'Club Activity Detail';
$params['sql'] = "
	select
		M.memberID,
		REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ') as Name,
		ST.statusType,
		DT.dateType,
		max(D.memberDate) as LastDate,
		floor(datediff(now(), max(D.memberDate))/30.4) as Months,
		-- D.dateDetail
		left(D.dateDetail,75) as DateDetail
	from members M
		inner join statusTypes ST on M.statusTypeID_fk = ST.statusTypeID
		inner join memberDates D on M.memberID = D.memberID_fk
		inner join dateTypes DT on D.dateTypeID_fk = DT.dateTypeID
	where
		D.dateTypeID_fk <> 2
	group by
		M.memberID,
		REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' '),
		ST.statusType,
		DT.dateType,
		-- D.dateDetail
		left(D.dateDetail,75)
	order by
		max(D.memberDate) desc,
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
<link rel="stylesheet" type"text/css" href="../lib/reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
