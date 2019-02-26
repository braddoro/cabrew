<?php
$hostname = gethostname();
if($hostname == 'chimera'){
	require_once '../../adodb5/adodb.inc.php'; // localhost
}else{
	require_once '../adodb5/adodb.inc.php'; // cabrew.org
}
$cabrew_array = parse_ini_file('access.ini', true);
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
$classes[] = "ContextMenu.js";
$classes[] = "Navigation.js";
$classes[] = "Desktop.js";
$classes[] = "Shared.js";
$classes[] = "Users.js";
$classes[] = "Items.js";
$classes[] = "Groups.js";
$classes[] = "UserGroups.js";
$classes[] = "ItemGroups.js";
$classes[] = "ShowInfo.js";
echo "<html>
<head>
<script>var isc = null;</script>
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
// foreach ($cmdret as $key) {
// 	$str .= $key . '<br/>';
// }
$str = '';
echo 'isc.Desktop.create({data: "'. $str .'"});
</script>
</body>
</html>';
?>
