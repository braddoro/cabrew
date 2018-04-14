<?php
$year = 2018;
require_once('../reports/inc/Reporter.php');
$params['bind'] = array();
$params['ini_file'] = '../reports/inc/server.ini';
$params['skip_format'] = true;
$params['sql'] = "select postText from web_posts where webPostID = 4;";
$lclass = New Reporter();
$html = $lclass->init($params);
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
						<h1>NCHI Media Presentation</h1>
						<hr class="small">
						<span class="subheading">North Carolina Homebrew Invitational</span>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="output" id="dateout"></div>
	<div class="container"><?php echo $html;?>
		<span style="font-size: 16pt; font-family: Arial; vertical-align: baseline; white-space: pre-wrap;">Here are a couple short videos.
		<a href="NCHI_Mini_Promo2017.mp4" target="_blank">Mini Video (30 seconds)</a>
		<a href="NCHI_Short_Promo2017.mp4" target="_blank">Short Video (90 seconds)</a>
	</span>
</body>
</html>
<script type="text/javascript">
	var daystill = calcTarget("10/13");
	var daysout = 'Only '+daystill+' days until the Invitational.  Are you ready?';
	document.getElementById("dateout").innerHTML = daysout;
</script>
