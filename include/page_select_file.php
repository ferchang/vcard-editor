<?php

$files=glob('vcards/*.vcf');

/*if(count($files)===1) {
	$file=basename($files[0]);
	header("Location: $target?file=$file");
	exit;
}*/

?>
<html>
<head>
<script>
<?php
if($target==='vcard_editor.php') echo 'vcard_editor=true;';
else echo 'vcard_editor=false;';
echo "\n";
?>
</script>
<link href="css/common.css" media="screen" rel="stylesheet" type="text/css" />
<style>
li {
	margin: 10px;
	font-size: 15pt;
}
</style>
<script src='js/jscookie.js'></script>
<script src='js/jquery.js'></script>
<script>
function loaded() {
	if(!vcard_editor) return;
	if(Cookies.get('contacts2show')) $('#contacts2show_select').val(Cookies.get('contacts2show'));
}
function item_clicked() {
	if(!vcard_editor) return;
	Cookies.set('contacts2show', $('#contacts2show_select').val());
}
</script>
</head>
<body onload='loaded()'><table width='100%' height='100%'><tr><td align=center valign=center>
<h3>Choose a file:</h3>
<?php

if($target==='vcard_editor.php') {
	echo '<b>Contacts to display: </b>';
	echo '<select name=contacts2show id=contacts2show_select>';
	echo '<option>All<option>1<option>5<option>10<option>20<option>50<option>100<option>500<option>1000';
	echo '</select>';
}

if(!count($files)) echo '<h4 style="color: red">No vcard (.vcf) files found!</h4>';

echo '<table><tr><td><ul><ol>';

foreach($files as $filename) {
	
	$contents=file_get_contents($filename);
	
	$pat='/BEGIN:VCARD.*?END:VCARD/s';

	preg_match_all($pat, $contents, $matches);

	$num_contacts=count($matches[0]);
	
	$filename=basename($filename);

	echo "<li><a href='$target?file=$filename' onclick='item_clicked()'>$filename</a>&nbsp;&nbsp;<span title='Number of contacts'>($num_contacts)</span>";

}

echo '</ol></td></tr></table>';

?>
<a href=index.php>Home</a></td></tr></table>
</body>
</html>