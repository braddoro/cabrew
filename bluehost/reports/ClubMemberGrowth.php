<?php
require_once('../shared/Reporter.php');
$cabrew_array = parse_ini_file('../smart/cabrew.ini', true);
$mainTitle = $cabrew_array['reports']['default_main_title'];

require_once('../shared/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../shared/server.ini';
$params['show_total'] = true;
$params['maintitle'] = $mainTitle;
$params['title'] = "Membership Add and Drop Rate";
$params['sql'] = "
select st.statusType 'Status', max(year(d.memberDate)) 'Year', count(*) 'Members'
from members m
inner join memberDates d on m.memberID = d.memberID_fk and d.dateTypeID_fk = 1
inner join statusTypes st on m.statusTypeID_fk = st.statusTypeID
where m.statusTypeID_fk <> 5
group by st.statusType, year(d.memberDate)
order by year(d.memberDate), st.statusType;";
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
