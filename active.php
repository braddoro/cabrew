<!DOCTYPE html>
<html>
<body>
<head>
	<title>Active</title>
<style>
.odd{
	background-color: #DCDCDC;
	font-family: sans-serif;
}
.even{
	background-color: #F5F5F5;
	font-family: sans-serif;
}
.label{
	background-color: #F5F5F5;
	font-family: sans-serif;
	font-weight: bold;
}
</style>
</head>
<?php
try {
	$dbhost = 'bd7rbk520-mysql.services.clever-cloud.com';
	$dbuser = 'uynjf3gxdxglgxff';
	$dbpass = 'FbhJhPM89r38ZhaDmeY';
	$schema = 'bd7rbk520';
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$schema);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n",$mysqli->connect_error);
		exit();
	}
	$sql = "
	select
		M.memberID,
		M.firstName,
		M.lastName,
		ST.statusType,
		M.renewalMonth,
		floor(datediff(now(), max(D.memberDate))/30.4) as 'MonthsSincePayment',
		max(D.memberDate) as 'LastPaid',
		C1.memberContact as 'Phone',
		C2.memberContact as 'Email',
		C3.memberContact as 'Address'
	from members M
	inner join statusTypes ST on M.statusTypeID_fk = ST.statusTypeID and ST.statusTypeID not in (4,5)
	inner join memberDates D on M.memberID = D.memberID_fk and D.dateTypeID_fk = 3
	left join memberContacts C1 on M.memberID = C1.memberID_fk and C1.contactTypeID_fk = 1
	left join memberContacts C2 on M.memberID = C2.memberID_fk and C2.contactTypeID_fk = 2
	left join memberContacts C3 on M.memberID = C3.memberID_fk and C3.contactTypeID_fk = 3
	group by
		M.memberID,
		M.firstName,
		M.lastName,
		ST.statusType,
		M.statusTypeID_fk,
		M.renewalMonth
	order by
		M.renewalMonth,
		max(D.memberDate),
		M.lastName,
		M.firstName;
	";
	if (!$result = $mysqli->query($sql)) {
		echo "Error: " . $mysqli->error . "\n";
		exit();
	}
	echo "<table class='odd'>" . PHP_EOL;
	$finfo = $result->fetch_fields();
	echo "\t<tr>" . PHP_EOL;
	foreach ($finfo as $val) {
		$base = $val->name;
		$fmt = '';
		for($x=0;$x<strlen($base);$x++){
			if(ctype_upper(substr($base,$x,1))){
				if(!ctype_upper(substr($base,$x-1,1))){
					$fmt .= ' ';
				}
			}
			$fmt .= substr($base,$x,1);
		}
		echo "\t\t<th>" . ucfirst($fmt) . "</th>" . PHP_EOL;
	}
	echo "\t<tr>" . PHP_EOL;
	$loop=0;
	while ($row = $result->fetch_object()) {
		$style = ($loop % 2 == 0) ? 'even' : 'odd';
		echo "\t<tr class='$style'>" . PHP_EOL;
		foreach($row as $field){
			echo "\t\t<td>" . $field . "</td>" . PHP_EOL;
		}
		echo "\t</tr>" . PHP_EOL;
		$loop++;
	}
	echo "</table>" . PHP_EOL;
	echo "<span class='label'>$loop</span>" . PHP_EOL;
	$result->free();
	$mysqli->close();
} catch (Exception $e) {
	echo "Caught exception: ",  $e->getMessage(), "\n";
}
?>
</body>
</html>
