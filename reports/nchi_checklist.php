<?php
require_once('../lib/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['title'] = 'NCHI 2018 Schedule';
$params['sql'] = "select C.phase, C.dueDate, C.status,
REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ',IFNULL(M.midName,''), ' ', M.lastName),'  ',' ') as 'FullName',
C.step, C.notes
from checklistData C
inner join checklistTypes T on D.checklistTypeID = T.checklistTypeID
left join members M on C.memberID_fk = M.memberID
C.checklistTypeID = 1
order by C.dueDate;";
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
<?php echo $html; ?>
</body>
</html>
