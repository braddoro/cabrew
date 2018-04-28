<?php
require_once('../lib/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../lib/server.ini';
$params['show_total'] = true;
$params['title'] = 'Metadata';
$params['sql'] = "select COLUMN_NAME, IS_NULLABLE, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_KEY from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'members';";
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
