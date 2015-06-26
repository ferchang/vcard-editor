<html>
<head>
<link href="css/common.css" media="screen" rel="stylesheet" type="text/css" />
<style>
li {
	margin: 10px;
	font-size: 15pt;
}
</style>
<script>
</script>
</head>
<body><table width='100%' height='100%'><tr><td align=center valign=center>
<h3>Input vcard file charset:</h3>
<?php

echo '<table><tr><td><ul>';

require 'include/config.php';

if(isset($_GET['search'])) $target='search.php';
else $target='vcard_editor.php';

foreach($charsets as $charset) {
	
	echo "<li><a href='$target?file={$_GET['file']}&charset=$charset'>$charset</a>";

}

echo '</ul></td></tr></table>';

?>
<a href=index.php>Home</a></td></tr></table>
</body>
</html>