<!DOCTYPE html>
<html>
<body>
<head>
	<title>Clubs</title>
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
		club.clubName,
		club.clubAbbr,
		club.city,
		club.state,
		contact.contactName,
		points.contactPoint,
		concat('<a href=\"',media.media,'\">url</a>') as 'web'
	from
		brew_clubs club
		inner join brew_contacts contact on club.clubID = contact.clubID
		inner join brew_contactPoints points on contact.contactID = points.contactID
		inner join contactTypes cp on points.contactTypeID_fk = cp.contactTypeID
		inner join brew_media media on club.clubID = media.clubID
		inner join contactTypes cp2 on media.contactTypeID_fk = cp2.contactTypeID
	where
		points.contactTypeID_fk = 2
		and contact.priority = 1
		and media.priority = 1
		and media.contactTypeID_fk = 5
	order by
		club.clubName,
		club.clubAbbr,
		contact.contactName,
		cp.contactType;
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
