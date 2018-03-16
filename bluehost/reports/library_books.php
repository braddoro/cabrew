<?php
require_once('inc/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = 'inc/server.ini';
$params['show_total'] = true;
$params['title'] = 'CABREW Library Books';
$params['sql'] = "select
trim(concat(ifnull(series,''), ' ', title)) as name,
author,
copyright,
abstract
from library_books
order by
trim(concat(ifnull(series,''), ' ', title));";
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
