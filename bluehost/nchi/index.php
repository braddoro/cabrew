<?php
$year = (isset($_GET['y'])) ? intval($_GET['y']) : date('Y');
$ini_array = parse_ini_file('../server.ini', true);
$hostname = $ini_array['database']['hostname'];
$username = $ini_array['database']['username'];
$password = $ini_array['database']['password'];
$database = $ini_array['database']['dbname'];
$dbport = 3306;
$con = mysqli_connect($hostname, $username, $password, $database, $dbport);
if(mysqli_connect_errno()){
	die("Failed to connect to MySQL using the PHP mysqli extension: " . mysqli_connect_error());
}
$query = 'select postText from web_posts where webPostID = 9;';
$result = mysqli_query($con, $query);
$html = '';
while($row = mysqli_fetch_array($result)){
	$html = $row[0];
}
mysqli_close($con);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title>NCHI - North Carolina Homebrew Invitational <?php echo $year;?></title>
<script src="cabrew.js" type="text/javascript"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/invite.css" rel="stylesheet">
<link href="nchi.css" rel="stylesheet">
<link rel="stylesheet" type"text/css" href="../lib/reporter.css">
</head>
<body>
	<header class="intro-header" style="background-image: url('../img/nchi<?php echo $year;?>banner.png')">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
					<div class="site-heading">
						<h1>NCHI <?php echo $year;?></h1>
						<hr class="small">
						<span class="subheading">North Carolina Homebrew Invitational</span>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="output" id="dateout"></div>
	<div class="container"><?php echo $html;?></div>
<!-- <span style="font-size: 14pt; font-family: Arial; vertical-align: baseline; white-space: pre-wrap;">Here is a link to a 3 minute video of NCHI from last year: <a href="https://youtu.be/3oIpssv4Cy0" target="_blank">NCHI 2018</a></style>&nbsp;<span style="font-size: 12pt; font-family: Arial; vertical-align: baseline; white-space: pre-wrap;"></style> -->
</body>
</html>
<script type="text/javascript">
	var daystill = calcTarget("10/03");
	var daysout = 'Only '+daystill+' days until the Invitational!';
	document.getElementById("dateout").innerHTML = daysout;
</script>
<?php
$d1 = fopen("countlog.txt", "r");
$count = fgets($d1, 1000);
fclose($d1);
$count = intval($count)+1;
echo "<p style='font-size: .666em; font-family: Arial;'>{$count}</p>";
$d2 = fopen("countlog.txt", "w");
fwrite($d2, "$count");
fclose($d2);
?>
