<?php
require_once('../lib/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['title'] = 'NCHI 2018 Schedule';
$params['sql'] = 'select phase, dueDate, status, step, assignee, notes from bd7rbk520.nchi_checklist order by dueDate;';
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
