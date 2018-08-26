<?php
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['show_total'] = true;
$params['bind'] = array();
$params['title'] = "Active Club Members";
$params['sql'] = "select
    M.memberID,
	M.firstName,
	M.midName,
    M.lastName,
    M.nickname,
    M.sex,
    MD.memberDate as 'joinDate',
    LM.lastMeeting,
    C.memberContact as 'Email'
from
	members M
    left join memberContacts C on M.memberID = C.memberID_fk
    left join memberDates MD on M.memberID = MD.memberID_fk
    left join (
        select MD.memberID_fk,
        max(MD.memberDate) AS lastMeeting
        from memberDates MD
        where MD.dateTypeID_fk = 6 -- Monthly Meeting
        group by MD.memberID_fk
    ) LM on M.memberID = LM.memberID_fk
where
	M.statusTypeID_fk = 1 -- Active
    and C.contactTypeID_fk = 2 -- Email
    and MD.dateTypeID_fk = 1 -- Join Date
order by
	M.firstName,
    M.lastName
;";
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
