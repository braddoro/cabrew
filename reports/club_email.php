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
$params['title'] = 'Club Email List';
$params['sql'] = "
	select
	trim(CONCAT(memberContact,',')) as email
	from members M
	inner join memberContacts C on M.memberID = C.memberID_fk
	where
	M.statusTypeID_fk = 1
	and C.contactTypeID_fk = 2
	-- and renewalYear = 2017
	order by
	memberContact;";
$lclass = New Reporter();
$html .= $lclass->init($params);
echo $html;
?>
</body>
</html>
