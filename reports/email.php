<?php
$title = 'Other Club Email List';
?>
<!DOCTYPE html>
<html>
<body>
<head>
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css"href="reports.css">
</head>
<span class="title"><?php echo $title; ?></span>
<?php
try {
	$server_array  = parse_ini_file('../lib/server.ini',true);
	$dbhost = $server_array['database']['hostname'];
	$dbuser = $server_array['database']['username'];
	$dbpass = $server_array['database']['password'];
	$schema = $server_array['database']['dbname'];
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$schema);
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n",$mysqli->connect_error);
		exit();
	}
	// CONCAT(contact.contactName,' <',points.contactPoint,'>') as email
	$sql = "
	select
		CONCAT(points.contactPoint, ', ') as email
	from
		brew_clubs club
		inner join brew_contacts contact on club.clubID = contact.clubID
		inner join brew_contactPoints points on contact.contactID = points.contactID
		inner join contactTypes cp on points.contactTypeID_fk = cp.contactTypeID
	where
		points.contactTypeID_fk = 2
		and contact.priority = 1
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
