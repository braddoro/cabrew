<?php
$ini_array = parse_ini_file('../reports/inc/server.ini', true);
$hostname = $ini_array['database']['hostname'];
$username = $ini_array['database']['username'];
$password = $ini_array['database']['password'];
$database = $ini_array['database']['dbname'];
$dbport = 3306;
$con = mysqli_connect($hostname,$username,$password,$database,$dbport);
if (mysqli_connect_errno()) {
	die ("Failed to connect to MySQL using the PHP mysqli extension: " . mysqli_connect_error());
}
$query = 'select postText from web_posts where webPostID = 5;';
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)) {
	echo $row[0];
}
mysqli_close($con);
?>
