<?php
require_once('../shared/Reporter.php');
$cabrew_array = parse_ini_file('../smart/cabrew.ini', true);
$mainTitle = $cabrew_array['reports']['default_main_title'];

require_once('../shared/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['maintitle'] = $mainTitle;
$params['title'] = 'Corporation Contacts';
$params['sql'] = "select
	name,
	contact,
	owner,
	type,
	phone,
	email,
	website,
	address
from
	corporations
order by
	name,
	contact
;";
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
<?php echo $html; ?>
</body>
</html>
