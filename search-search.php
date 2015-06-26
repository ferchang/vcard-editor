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
<table><tr><td>
<h3>Search in:</h3>
<ul>
<?php
$tmp=basename($_GET['file']);
echo "<li><a href='search.php?file={$_GET['file']}'>Previous search results</a>";
echo "<li><a href='search.php?file=$tmp'>Original file</a>";
?>
</ul></td></tr></table>
<a href=index.php>Home</a></td></tr></table>
</body>
</html>