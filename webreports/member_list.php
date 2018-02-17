<?php
require_once('inc/Reporter.php');
$params['ini_file'] = 'inc/server.ini';
$params['show_total'] = true;
$params['bind'] = array();
$params['title'] = "Active Members";
$params['sql'] = "select M.firstName, M.midName, M.lastName, M.nickname, M.sex from members M where M.statusTypeID_fk = 1 order by M.lastName, M.firstName";
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
