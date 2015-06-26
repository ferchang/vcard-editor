<?php

//shows all vcard fields that exist in the vcard file.
//used during development.

error_reporting(E_ALL);
ini_set('display_errors', '1');

if(!isset($_GET['file'])) {
	$target='show_all_fields.php';
	require 'include/page_select_file.php';
	exit;
}

$file=$_GET['file'];

header('content-type: text/html; charset=utf-8');

?>
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
<table><tr><td>
<?php

$contents=file_get_contents("vcards/$file");

$pat='/BEGIN:VCARD.*?END:VCARD/s';

preg_match_all($pat, $contents, $matches);

$cards=array();

foreach($matches[0] as $key=>$val) {

	$val.="\r\n";

	$pat='/([^:]+):([^:]+)\r\n/';

	preg_match_all($pat, $val, $matches);

	$cards[]=$matches[1];

}

$fields=array();

foreach($cards as $key=>$val) {

	foreach($val as $key2=>$val2) {

		if(!in_array($val2, $fields)) $fields[]=$val2;

	}

}

sort($fields);

echo '<div id=pre>';
echo "<h4 align=center id=header>All field types in <span style='color: green'>$file</span></h4>";
echo '<pre><big>';
print_r($fields);
echo '</big></pre></div>';

?>
</td></tr></table>
<a href=index.php>Home</a></td></tr></table>
</body>
</html>