<?php
require_once('../shared/Reporter.php');
$cabrew_array = parse_ini_file('../smart/cabrew.ini', true);
$mainTitle = $cabrew_array['reports']['default_main_title'];

require_once('../shared/Reporter.php');
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['bind'] = array();
$params['maintitle'] = $mainTitle;
$params['title'] = "Club Member Contacts";
$params['sql'] = "select
    M.memberID,
    M.firstName,
    M.midName,
    M.lastName,
    M.nickname,
    M.sex,
    MD.memberDate as 'joinDate',
    LM.lastMeeting,
    C1.memberContact as 'Phone',
    C2.memberContact as 'Email',
    C3.memberContact as 'Address'
from
    members M
    left join memberContacts C1 on M.memberID = C1.memberID_fk and C1.contactTypeID_fk = 1 -- Phone
    left join memberContacts C2 on M.memberID = C2.memberID_fk and C2.contactTypeID_fk = 2 -- Email
    left join memberContacts C3 on M.memberID = C3.memberID_fk and C3.contactTypeID_fk = 3 -- Address
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
    and MD.dateTypeID_fk = 1 -- Join Date
order by
    M.firstName,
    M.lastName;";
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
