<?php
$year = 2018;
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['bind'] = array();
$params['show_total'] = false;
$params['title'] = "NCHI Event Teams for {$year}";
$params['sql'] = "
select
	e.eventDay,
	et.teamName,
	IFNULL(e.teamMember,m.FullName) as Member,
	TIME_FORMAT(e.startTime, '%h:%i %p') Start,
	TIME_FORMAT(e.endTime, '%h:%i %p') End,
	m.memberContact,
	e.notes
from eventTeams e
inner join eventTeamNames et on e.eventTeamNameID = et.eventTeamNameID
left join (
	select
    M.memberID,
	REPLACE(CONCAT(IFNULL(M.nickName, M.firstName), ' ', IFNULL(M.midName, ''), ' ', M.lastName),'  ',' ') as 'FullName',
	C.memberContact
	from members M
	left join memberContacts C on C.memberID_fk = M.memberID
	where C.contactTypeID_fk = 1
) m on e.memberID = m.memberID
where e.eventID = 1
order by e.eventDay, e.startTime, et.teamName, IFNULL(e.teamMember,m.FullName);
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
<?php echo $html;?>
</body>
</html>
