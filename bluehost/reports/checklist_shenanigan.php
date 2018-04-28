<?php
require_once('inc/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = 'inc/server.ini';
$params['show_total'] = true;
$params['title'] = '2018 Shenanigan Day';
$params['sql'] = "select C.phase, C.dueDate, C.status,
(select REPLACE(CONCAT(IFNULL(M.nickName,M.firstName), ' ',IFNULL(M.midName,''), ' ', M.lastName),'  ',' ')
from members M where C.memberID_fk = M.memberID) as 'FullName',
C.step, C.cost, C.milestone, C.notes
from checklistData C
inner join checklistTypes T on C.checklistTypeID = T.checklistTypeID
and C.checklistTypeID = 3
order by C.dueDate;";
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
<?php echo $html; ?>
</body>
</html>
