<?php
// https://mattstauffer.co/blog/sublime-text-3-for-php-developers
$cabrew_array  = parse_ini_file('cabrew.ini',true);
$skin = $cabrew_array['application']['skin'];;
$title = $cabrew_array['application']['title'];
$client_path = 'client/';
$server_path = 'server/';
$classes = array();
$classes[] = "{$client_path}ClassDefaults.js";
$classes[] = "{$client_path}library.js";
$classes[] = "{$client_path}Desktop.js";
$classes[] = "{$client_path}Navigation.js";
$classes[] = "{$client_path}ContextMenu.js";
$classes[] = "{$client_path}Shared.js";
$classes[] = "{$client_path}AddEvent.js";
$classes[] = "{$client_path}AddMember.js";
$classes[] = "{$client_path}BrewAttendence.js";
$classes[] = "{$client_path}BrewClubs.js";
$classes[] = "{$client_path}BrewContactPoints.js";
$classes[] = "{$client_path}BrewContacts.js";
$classes[] = "{$client_path}BrewMedia.js";
$classes[] = "{$client_path}Corporations.js";
$classes[] = "{$client_path}EditMember.js";
$classes[] = "{$client_path}MemberChairs.js";
$classes[] = "{$client_path}MemberContacts.js";
$classes[] = "{$client_path}MemberDates.js";
$classes[] = "{$client_path}MemberNotes.js";
$classes[] = "{$client_path}MemberPoints.js";
$classes[] = "{$client_path}MemberStatus.js";
$classes[] = "{$client_path}SendMessage.js";
$classes[] = "{$client_path}ShowInfo.js";
//$classes[] = "{$client_path}Items.js";
//$classes[] = "{$client_path}UserStories.js";
echo "<html>
<head>
<script>var isomorphicDir='../../../SmartClient_v110p_2017-05-12_LGPL/smartclientRuntime/isomorphic/';</script>
<script src='../../../SmartClient_v110p_2017-05-12_LGPL/smartclientRuntime/isomorphic/system/modules/ISC_Core.js'></script>
<script src='../../../SmartClient_v110p_2017-05-12_LGPL/smartclientRuntime/isomorphic/system/modules/ISC_Foundation.js'></script>
<script src='../../../SmartClient_v110p_2017-05-12_LGPL/smartclientRuntime/isomorphic/system/modules/ISC_Containers.js'></script>
<script src='../../../SmartClient_v110p_2017-05-12_LGPL/smartclientRuntime/isomorphic/system/modules/ISC_Grids.js'></script>
<script src='../../../SmartClient_v110p_2017-05-12_LGPL/smartclientRuntime/isomorphic/system/modules/ISC_Forms.js'></script>
<script src='../../../SmartClient_v110p_2017-05-12_LGPL/smartclientRuntime/isomorphic/system/modules/ISC_DataBinding.js'></script>
<script src='../../../SmartClient_v110p_2017-05-12_LGPL/smartclientRuntime/isomorphic/skins/{$skin}/load_skin.js'></script>

<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>$title</title>
</head>
<body>
<script type=\"text/javascript\">var application.server_path = \"$server_path\";</script>
<script>
";
$content = '';
foreach($classes as $class) {if(file_exists($class)){$content .= file_get_contents($class);}}
echo $content;
$cmdret = '';
exec("git status --short --branch",$cmdret);
$str='';
foreach ($cmdret as $key) {
	$str .= $key . '<br/>';
}
echo 'isc.Desktop.create({gitInfo: "'. $str .'"});';
echo '</script>
</body>
</html>';
?>
