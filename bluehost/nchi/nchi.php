<?php
$year = 2018;
require_once('../reports/inc/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../reports/inc/server.ini';
$params['skip_format'] = true;
$params['sql'] = "select postText from web_posts where webPostID = 1;";
$lclass = New Reporter();
$html = $lclass->init($params);

$d1 = fopen("countlog.txt","r");
$count = fgets($d1,1000);
fclose($d1);
$count = intval($count)+1;
$d2 = fopen("countlog.txt","w");
fwrite($d2, "$count");
fclose($d2);
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title>NCHI - North Carolina Homebrew Invitational 2018</title>
<script src="cabrew.js" type="text/javascript"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/invite.css" rel="stylesheet">
<link href="nchi.css" rel="stylesheet">
<link rel="stylesheet" type"text/css" href="../lib/reporter.css">
</head>
<body>
	<header class="intro-header" style="background-image: url('../img/invite_bg.jpg')">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
					<div class="site-heading">
						<h1>NCHI 2018</h1>
						<hr class="small">
						<span class="subheading">North Carolina Homebrew Invitational</span>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="output" id="dateout"></div>
	<div class="container"><?php echo $html;?>
<a href="media.php" target="_blank"><span style="font-size: 14pt; font-family: Arial; vertical-align: baseline; white-space: pre-wrap;">Follow this link for images and short videos from 2017.</span></a>
	</div>
<br>
</body>
</html>
<script type="text/javascript">
	var daystill = calcTarget("10/13");
	var daysout = 'Only '+daystill+' days until the Invitational.  Are you ready?';
	document.getElementById("dateout").innerHTML = daysout;
</script>
<?php
// $datei = fopen("countlog.txt","r");
// $count = fgets($datei,1000);
// fclose($datei);
// echo "-- {$count} --";
// $count = intval($count)+1;
// $datei = fopen("countlog.txt","w");
// fwrite($datei, "$count");
// fclose($datei);
?>
