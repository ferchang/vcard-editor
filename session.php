<html>
<head>
<link href="css/common.css" media="screen" rel="stylesheet" type="text/css" />
<style>
#pre {
	border: thin solid #000;
	padding: 10px;
	padding-top: 0px;
	background: #eee;
}
#header {

}
</style>
<script>
</script>
</head>
<body><table width='100%' height='100%'><tr><td align=center valign=center>
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if(isset($_COOKIE['vcard_editor_session'])) {
	
	session_name('vcard_editor_session');
	session_start();
	
	if(isset($_POST['destroy'])) {
		session_name('vcard_editor_session');
		session_start();
		session_destroy();
		header("Location: {$_SERVER['PHP_SELF']}");
		exit;
	}
	
	echo '<table align="center" cellpadding="10" style=""><tr><td>';
	echo "<div id=pre><h4 align=center id=header>Session contents</h4>";
	echo '<pre>';
	print_r($_SESSION);
	echo '</pre></div><br><center><form style="margin-bottom: 0px" method="post" action=""><input type="submit" name="destroy" value="Destroy session"></form></center></td></tr></table>';
}
else echo '<center>No session (cookie) exists.</center>';

?>
<a href=index.php>Home</a></td></tr></table>
</body>
</html>