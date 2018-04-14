<?php
// https://mattstauffer.co/blog/sublime-text-3-for-php-developers
$cabrew_array  = parse_ini_file('cabrew.ini', true);
$skin = $cabrew_array['application']['skin'];;
$title = $cabrew_array['application']['title'];
$source_path = $cabrew_array['application']['source_path'];
$smart_ver = $cabrew_array['application']['smartclient_version'];
$client_path = $cabrew_array['application']['client_path'];
$server_path = $cabrew_array['application']['server_path'];
$classes = array();
$classes[] = "ClassDefaults.js";
$classes[] = "library.js";
$classes[] = "Desktop.js";
$classes[] = "Navigation.js";
$classes[] = "ContextMenu.js";
$classes[] = "Shared.js";
$classes[] = "AddEvent.js";
$classes[] = "AddMember.js";
$classes[] = "AddPayment.js";
$classes[] = "BrewAttendence.js";
$classes[] = "BrewClubs.js";
$classes[] = "BrewContactPoints.js";
$classes[] = "BrewContacts.js";
$classes[] = "BrewMedia.js";
$classes[] = "Corporations.js";
$classes[] = "EditMember.js";
$classes[] = "LibraryBooks.js";
$classes[] = "LibraryLoans.js";
$classes[] = "MemberChairs.js";
$classes[] = "MemberContacts.js";
$classes[] = "MemberDates.js";
$classes[] = "MemberNotes.js";
$classes[] = "MemberPoints.js";
$classes[] = "DateTypes.js";
$classes[] = "MemberStatus.js";
$classes[] = "MemberDetails.js";
$classes[] = "NCHISchedule.js";
$classes[] = "Preview.js";
$classes[] = "WebPosts.js";
$classes[] = "SendMessage.js";
$classes[] = "ShowInfo.js";
$classes[] = "ScheduleTypes.js";
echo "<html>
<head>
<script>var serverPath = '$server_path';</script>
<script>var isomorphicDir = '{$source_path}{$smart_ver}/smartclientRuntime/isomorphic/';</script>
<script src='{$source_path}{$smart_ver}/smartclientRuntime/isomorphic/system/modules/ISC_Core.js'></script>
<script src='{$source_path}{$smart_ver}/smartclientRuntime/isomorphic/system/modules/ISC_Foundation.js'></script>
<script src='{$source_path}{$smart_ver}/smartclientRuntime/isomorphic/system/modules/ISC_Containers.js'></script>
<script src='{$source_path}{$smart_ver}/smartclientRuntime/isomorphic/system/modules/ISC_Grids.js'></script>
<script src='{$source_path}{$smart_ver}/smartclientRuntime/isomorphic/system/modules/ISC_Forms.js'></script>
<script src='{$source_path}{$smart_ver}/smartclientRuntime/isomorphic/system/modules/ISC_DataBinding.js'></script>
<script src='{$source_path}{$smart_ver}/smartclientRuntime/isomorphic/system/modules/ISC_RichTextEditor.js'></script>
<script src='{$source_path}{$smart_ver}/smartclientRuntime/isomorphic/skins/{$skin}/load_skin.js'></script>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>$title</title>
</head>
<body>
<script>
";
$content = '';
foreach($classes as $class) {
	if(file_exists($client_path . $class)){
		$content .= file_get_contents($client_path . $class);
	}
}
echo $content;
$cmdret = '';
exec("git status --short --branch", $cmdret);
$str='';
foreach ($cmdret as $key) {
	$str .= $key . '<br/>';
}
echo 'isc.Desktop.create({gitInfo: "'. $str .'"});
</script>';
echo '
</body>
</html>';
?>
