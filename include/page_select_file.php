<?php

$files=glob('vcards/*.vcf');

if(count($files)===1) {
	$file=basename($files[0]);
	header("Location: vcard_editor.php?file=$file");
	exit;
}

?>
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
<h3>Choose a file:</h3>
<?php

echo '<table><tr><td><ul><ol>';

foreach($files as $filename) {
	
	$contents=file_get_contents($filename);
	
	$pat='/BEGIN:VCARD.*?END:VCARD/s';

	preg_match_all($pat, $contents, $matches);

	$num_contacts=count($matches[0]);
	
	$filename=basename($filename);

	echo "<li><a href='$target?file=$filename'>$filename</a>&nbsp;&nbsp;<span title='Number of contacts'>($num_contacts)</span>";

}

echo '</ol></td></tr></table>';

?>
<a href=index.php>Home</a></td></tr></table>
</body>
</html>