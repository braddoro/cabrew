<?php
$hostname = gethostname();
if($hostname == 'chimera'){
	require_once '../../adodb5/adodb.inc.php'; // localhost
}else{
	require_once '../adodb5/adodb.inc.php'; // cabrew.org
}
$cabrew_array = parse_ini_file('cabrew.ini', true);
$skin = $cabrew_array['application']['skin'];;
$title = $cabrew_array['application']['title'];
$source_path = $cabrew_array['application']['source_path'];
$smart_ver = $cabrew_array['application']['smartclient_version'];
$client_path = $cabrew_array['application']['client_path'];
$server_path = $cabrew_array['application']['server_path'];
$shared_path = $cabrew_array['application']['shared_path'];
$classes = array();
$classes[] = "ClassDefaults.js";
$classes[] = "library.js";
$classes[] = "AddEvent.js";
$classes[] = "AddPayment.js";
$classes[] = "BrewAttendance.js";
$classes[] = "BrewClubs.js";
$classes[] = "BrewContactPoints.js";
$classes[] = "BrewContacts.js";
$classes[] = "BrewMedia.js";
$classes[] = "ChairTypes.js";
$classes[] = "ClubSearch.js";
$classes[] = "ContactTypes.js";
$classes[] = "ContextMenu.js";
$classes[] = "Corporations.js";
$classes[] = "DateTypes.js";
$classes[] = "Desktop.js";
$classes[] = "EditMember.js";
$classes[] = "EventAttendance.js";
$classes[] = "EventBeers.js";
$classes[] = "EventPlans.js";
$classes[] = "EventSchedules.js";
$classes[] = "EventTeamNames.js";
$classes[] = "EventTeams.js";
$classes[] = "EventTypes.js";
$classes[] = "Groups.js";
$classes[] = "ItemGroups.js";
$classes[] = "Items.js";
$classes[] = "LibraryBooks.js";
$classes[] = "LibraryLoans.js";
$classes[] = "Login.js";
$classes[] = "MemberChairs.js";
$classes[] = "MemberContacts.js";
$classes[] = "MemberDates.js";
$classes[] = "MemberDetails.js";
$classes[] = "MemberHistory.js";
$classes[] = "MemberNotes.js";
$classes[] = "MemberPoints.js";
$classes[] = "MemberSearch.js";
$classes[] = "Navigation.js";
$classes[] = "NoteTypes.js";
$classes[] = "Preview.js";
$classes[] = "Shared.js";
$classes[] = "ShowInfo.js";
$classes[] = "ShowLog.js";
$classes[] = "StatusTypes.js";
$classes[] = "test.js";
$classes[] = "UserDateTypes.js";
$classes[] = "UserGroups.js";
$classes[] = "Users.js";
$classes[] = "WebPosts.js";
echo "<html>
<head>
<script>var isc = null;</script>
<script>var saveUserID = 0;</script>
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
// $cmdret = '';
// exec("git status --short --branch", $cmdret);
// $str='';
// foreach ($cmdret as $key) {
// 	$str .= $key . '<br/>';
// }
// http://cabrew.org/
// https://twitter.com/HomebrewCABREW
// https://www.facebook.com/homebrewCABREW/
//
$now = date(DATE_RFC2822);
$str = "<strong>CABREW Links</strong><br><a href='http://cabrew.org/' target='_blank'>cabrew</a><br><a href='http://cabrew.org/reports/' target='_blank'>reports</a><br><a href='http://cabrew.org/nchi/' target='_blank'>nchi</a><br><br><a href='https://www.facebook.com/homebrewCABREW/' target='_blank'>faceboook</a><br><a href='https://twitter.com/HomebrewCABREW' target='_blank'>twitter</a><br><a href='https://www.facebook.com/groups/371109786956/' target='_blank'>cabrew group</a><br><a href='https://www.facebook.com/groups/cabrew/' target='_blank'>members only</a><br><br>{$now}<br>";
echo 'isc.Desktop.create({data: "'. $str .'"});
</script>
</body>
</html>';
?>
