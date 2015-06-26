<?php

if(!isset($_GET['file'])) {
	$target='search.php';
	require 'include/page_select_file.php';
	exit;
}
$file=$_GET['file'];

require 'include/config.php';

if(isset($_GET['for'])) {
	require 'include/func_kaaf8yeh.php';
	$_GET['for']=kaaf8yeh($_GET['for']);
	//exit($redir_address);
	header("Location: vcard_editor.php?file=$file&for={$_GET['for']}&in={$_GET['in']}");
	exit;
}

$contents=file_get_contents("vcards/$file");

session_name('vcard_editor_session');
session_start();

require 'include/code_detect_charset8encoding.php';

header("Content-type: text/html; charset=$charset");

?>
<html>
<head>
<link href="css/common.css" media="screen" rel="stylesheet" type="text/css" />
<style>
</style>
<script>
</script>
</head>
<body><table width='100%' height='100%'><tr><td align=center valign=center>
<table><tr><td>
<form action='' method=get>
<?php
echo "<center><a href=search.php>File</a>: {$_GET['file']} &nbsp;&nbsp; <a href='change_charset.php?file=$file&search'>Charset</a>: $charset";
echo " ($charset_detection_method)";
echo "</center><br>";
?>
<input type=hidden name=file value='<?php echo $_GET['file']; ?>'>
<?php
if(isset($_GET['charset'])) echo "<input type=hidden name=charset value='{$_GET['charset']}'>";
?>
Search for: <input type=text name=for>
in: <select name=in>
<option>All
<option>Names
<option>Numbers
</select>
<input type=submit value=Search />
</form>
</td></tr></table>
<a href=index.php>Home</a></td></tr></table>
</body>
</html>