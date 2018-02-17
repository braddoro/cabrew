<!DOCTYPE html>
<html>
<body>
<head>
<title>Tasks</title>
<link rel="stylesheet" type"text/css" href="../lib/reporter.css">
</head>
<body>
<?php
$html = '';
require_once('../lib/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['title'] = 'Active Member List';
$params['sql'] = "select
		REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' ') as 'FullName',
		ST.statusType,
		M.renewalYear,
		floor(datediff(now(), max(D.memberDate))/30.4) as 'MonthsSincePayment',
		max(D.memberDate) as 'LastPaid',
		C1.memberContact as 'Phone',
		C2.memberContact as 'Email',
		C3.memberContact as 'Address'
	from members M
		inner join statusTypes ST on M.statusTypeID_fk = ST.statusTypeID and ST.statusTypeID not in (4)
		inner join memberDates D on M.memberID = D.memberID_fk and D.dateTypeID_fk = 3
		left join memberContacts C1 on M.memberID = C1.memberID_fk and C1.contactTypeID_fk = 1
		left join memberContacts C2 on M.memberID = C2.memberID_fk and C2.contactTypeID_fk = 2
		left join memberContacts C3 on M.memberID = C3.memberID_fk and C3.contactTypeID_fk = 3
	group by
		REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' '),
		ST.statusType,
		M.statusTypeID_fk,
		M.renewalYear
	order by
		REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', M.lastName),'  ',' '),
		max(D.memberDate) desc,
		M.renewalYear
		;
";
$lclass = New Reporter();
$html .= $lclass->init($params);
echo $html;
?>
</body>
</html>
