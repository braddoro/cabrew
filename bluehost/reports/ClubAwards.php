<?php
require_once('../shared/Reporter.php');
$cabrew_array = parse_ini_file('../smart/cabrew.ini', true);
$mainTitle = $cabrew_array['reports']['default_main_title'];
$awardNameID = $cabrew_array['reports']['default_event'];

$awardNameID = 0;
if(isset($_GET['a'])){
	$awardNameID = intval($_GET['a']);
}
$year = date('Y');
if(isset($_GET['y'])){
	$year = intval($_GET['y']);
}
$isRookie = false;
if(isset($_GET['r'])){
	$isRookie = true;
}
$type4 = '';
if($awardNameID == 4 && $isRookie){
	$type4 = " having min(year(d.memberDate)) = $year ";
}
// Get a custom title.
//
$params['ini_file'] = '../shared/server.ini';
$params['bind'] = array("awardNameID" => $awardNameID);
$params['sql'] = "select awardName from awardNames where awardNameID = :awardNameID;";
$params['skip_format'] = true;
$lclass = New Reporter();
$data = $lclass->init($params);
$title = '';
while($row = $data->fetch()){
	foreach($row as $col => $val){
		$title = $val;
	}
}

$params = array();
$params['ini_file'] = '../shared/server.ini';
$params['bind'] = array("awardNameID" => $awardNameID, 'year' => $year);
$params['show_total'] = false;
$params['maintitle'] = $mainTitle;
$params['title'] = $title . ' Award for ' . $year;
$params['sql'] = "select
	M.memberID,
	REPLACE(CONCAT(M.firstName,' ',IFNULL(M.midName,''),' ',M.lastName),'  ',' ') as 'FullName',
	sum(dt.datePoints) as 'totalPoints'
from
	memberDates d
	inner join members M on M.memberID = d.memberID_fk
	inner join dateTypes dt on d.dateTypeID_fk = dt.dateTypeID
	inner join awardGroups ag on ag.dateTypeID_fk = dt.dateTypeID
 	inner join awardNames an on ag.awardNameID_fk = an.awardNameID
where
	year(d.memberDate) =  :year
	and M.statusTypeID_fk = 1
	and ag.awardNameID_fk = :awardNameID
group by
	M.memberID,
	REPLACE(CONCAT(M.firstName,' ',IFNULL(M.midName,''),' ',M.lastName),'  ',' ')
order by
	sum(dt.datePoints) desc,
	REPLACE(CONCAT(M.firstName,' ',IFNULL(M.midName,''),' ',M.lastName),'  ',' ')
;";
// {$type4}
// echo $params['sql'] . PHP_EOL;
$lclass = New Reporter();
$html = $lclass->init($params);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title><?php echo 'Event Budget' ?></title>
<link rel="stylesheet" type"text/css" href="../reporter.css">
</head>
<body>
<?php echo $html;?>
</body>
</html>
