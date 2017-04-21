<?php
// https://mattstauffer.co/blog/sublime-text-3-for-php-developers
/*
0 BlackOps
0 ToolSkin
0 ToolSkinNative
2 SmartClient
3 TreeFrog
3 Cupertino
3 Mobile
3 SilverWave
3 standard
4 Enterprise
4 Simplicity
5 fleet
6 EnterpriseBlue
7 Graphite
*/
$title = 'Cabarrus Homebrewers Society';
$classes = array();
$classes[] = 'ClassDefaults.js';
$classes[] = 'library.js';
$classes[] = 'Desktop.js';
$classes[] = 'Navigation.js';
$classes[] = 'ContextMenu.js';
$classes[] = 'Shared.js';
$classes[] = 'MemberChairs.js';
$classes[] = 'MemberContacts.js';
$classes[] = 'MemberDates.js';
$classes[] = 'MemberNotes.js';
$classes[] = 'MemberPoints.js';
$classes[] = 'MemberStatus.js';
$classes[] = 'BrewAttendence.js';
$classes[] = 'BrewClubs.js';
$classes[] = 'BrewContacts.js';
$classes[] = 'BrewContactPoints.js';
$classes[] = 'BrewMedia.js';
$classes[] = 'ShowInfo.js';
//$classes[] = 'TestData.js';
echo "<html>
<head>
<script>var isomorphicDir='../../../smartclientRuntime/isomorphic/';</script>
<script src='../../../smartclientRuntime/isomorphic/system/modules/ISC_Core.js'></script>
<script src='../../../smartclientRuntime/isomorphic/system/modules/ISC_Foundation.js'></script>
<script src='../../../smartclientRuntime/isomorphic/system/modules/ISC_Containers.js'></script>
<script src='../../../smartclientRuntime/isomorphic/system/modules/ISC_Grids.js'></script>
<script src='../../../smartclientRuntime/isomorphic/system/modules/ISC_Forms.js'></script>
<script src='../../../smartclientRuntime/isomorphic/system/modules/ISC_DataBinding.js'></script>
<script src='../../../smartclientRuntime/isomorphic/skins/fleet/load_skin.js'></script>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>$title</title>
</head>
<body>
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
