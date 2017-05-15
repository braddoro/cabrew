<!DOCTYPE html>
<html>
<body>
<head>
	<title>Member Activity</title>
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
		concat(M.firstName, ' ',M.lastName) as Name,
		ST.statusType,
		DT.dateType,
		max(D.memberDate) as LastDate,
		floor(datediff(now(), max(D.memberDate))/30.4) as Months,
		left(D.dateDetail,75) as DateDetail
		-- M.memberID,
		-- M.statusTypeID_fk,
		-- M.renewalMonth,
	from members M
		inner join statusTypes ST on M.statusTypeID_fk = ST.statusTypeID
		inner join memberDates D on M.memberID = D.memberID_fk
		inner join dateTypes DT on D.dateTypeID_fk = DT.dateTypeID
	-- where
	-- 	and D.dateTypeID_fk <> 2
	group by
		concat(M.firstName, ' ',M.lastName),
		ST.statusType,
		DT.dateType,
		left(D.dateDetail,75)
		-- M.memberID,
		-- M.statusTypeID_fk,
		-- M.renewalMonth,
		-- having floor(datediff(now(), max(D.memberDate))/30.4) > 12
	order by
		max(D.memberDate) desc,
		M.firstName,
		M.lastName;
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
		echo "\t\t<th>" . ucfirst($fmt) . "&nbsp;&nbsp;</th>" . PHP_EOL;
	}
	echo "\t<tr>" . PHP_EOL;
	$loop=0;
	while ($row = $result->fetch_object()) {
		$style = ($loop % 2 == 0) ? 'even' : 'odd';
		echo "\t<tr class='$style'>" . PHP_EOL;
		foreach($row as $field){
			echo "\t\t<td>" . $field . "&nbsp;&nbsp;</td>" . PHP_EOL;
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
