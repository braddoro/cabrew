<?php
$year = 2018;
require_once('../shared/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../shared/server.ini';
$params['maintitle'] = 'Cabarrus Homebrewers Society Reporting';
$params['title'] = 'CABROINT Values';
$params['sql'] = "select dateTypeID, dateType, datePoints as 'Points' from dateTypes where datePoints > 0 and active = 'Y' order by dateType;";
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
