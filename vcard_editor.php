<?php

/*
v 0.7.2
ad-hoc vcard editor by hamidreza.mz712 -=At=- gmail -=Dot=- com
this works with vcard v2.1 format.
probably not usable as a general vcard editor, but i hope the code can be useful for possibly future projects.
License: GPL v2 or higher
*/

error_reporting(E_ALL);
ini_set('display_errors', '1');

set_time_limit(120);

require 'include/config.php';

if(isset($_POST['go'])) {
	$sort_field=$_POST['sort_field'];
	$aggregate_cell_numbers=isset($_POST['aggregate_cell_numbers']);
	$kaaf8yeh=$_POST['kaaf8yeh'];
	$preserve_photos=isset($_POST['preserve_photos']);
	$show_photos=isset($_POST['show_photos']);
	$_POST=array();
}

session_name('vcard_editor_session');
session_start();

if(!isset($_GET['file'])) {
	$target='vcard_editor.php';
	require 'include/page_select_file.php';
	exit;
}

$file=$_GET['file'];

if(strpos($file, 'search/')!==false) $search=true;
else $search=false;

$contents=file_get_contents("vcards/$file");

require 'include/code_check_undo_files.php';

if(isset($_POST['undo'])) require 'include/code_undo.php';

require 'include/code_detect_charset8encoding.php';

if(!empty($_POST)) {
	if(isset($_POST['output_quoted_printable'])) $output_quoted_printable=true;
	else $output_quoted_printable=false;
	$_SESSION[$file]['output_quoted_printable']=(int)$output_quoted_printable;
	if(isset($_POST['preserve_photos'])) $preserve_photos=true;
	else $preserve_photos=false;
}
else {
	if(isset($_SESSION[$file]['output_quoted_printable'])) $output_quoted_printable=$_SESSION[$file]['output_quoted_printable'];
	else if($save_quoted_printable_encode==='no' or ($save_quoted_printable_encode==='' and !$input_quoted_printable)) $output_quoted_printable=false;
	else $output_quoted_printable=true;
}

require 'include/func_kaaf8yeh.php';

require 'include/code_write_vcards.php';

require 'include/code_read_vcards.php';

require 'include/code_prepare_names.php';

require 'include/code_search.php';

require 'include/code_aggregate_cell_numbers.php';

require 'include/code_sort_vcards.php';

require 'include/code_detect_errors.php';

require 'include/code_detect_repetitives.php';

header("Content-type: text/html; charset=$charset");

?>

<html dir=rtl>
<head>
<link href="css/common.css" media="screen" rel="stylesheet" type="text/css" />
<style>
input, textarea {
	width: 130px;
}
textarea {
	height: 25px;
}
span.config_val {
	color: blue;
}
a {
	color: #000;
}
#header {
	font-size: 12pt;
}
#contacts {
	background: #ced;
}
<?php
if($search) echo 'body { border: thick solid orange; padding: 10px; }';
?>
</style>
<script src='js/jquery.js'></script>
<script src='js/my.js'></script>
</head>
<body dir=rtl onload='on_load();' >

<div id="alert_div" style="position: absolute; top: 0px; left: 0px; visibility: hidden; text-align: center" ><div id="alert_title_div" style="font-size: bigger; font-weight: bold" align="center"></div><br><div id="alert_contents_div" "></div><br><a id="alert_close" href="javascript: hide_alert()" style="margin-top: 5px; color: inherit">Close</a></center></div>

<?php

echo '<form action="" method=post style="">';
echo "<center dir=ltr id=header><span style='float: left'><a href='index.php'>Home</a>&nbsp;|&nbsp;";
echo "<a href='";
if($search) {
	if(empty($cards)) echo "search.php?file=", basename($file);
	else echo "search-search.php?file=$file";
}
else echo "search.php?file=$file";
echo "'>Search</a></span><a href=";
if($search) echo 'search.php';
else echo 'vcard_editor.php';
echo ">File</a>: <span class='config_val'>$file</span>&nbsp;&nbsp;<a href='change_charset.php?file=$file'>Charset</a>: <span class='config_val'>$charset</span> ($charset_detection_method)";
echo "&nbsp;&nbsp;Contacts: <span class='config_val'>$num_contacts</span>";
echo '&nbsp;&nbsp;Input quoted printable: <span class=config_val>';
if($input_quoted_printable) echo 'Yes';
else echo 'No';
echo '</span>';
if(!$search) {
	echo '&nbsp;&nbsp;Output quoted printable: <span class=config_val>';
	echo '<input type=checkbox id=no_del name=output_quoted_printable style="width: 10px; vertical-align: middle" ';
	if($output_quoted_printable) echo 'checked';
	echo '>';
	echo '</span>';
	echo "&nbsp;&nbsp;preserve_photos: <span class='config_val'>";
	echo '<input type=checkbox name=preserve_photos style="width: 10px; vertical-align: middle" ';
	if($preserve_photos) echo 'checked';
	echo '></span>';
}
echo "<br><br><fieldset>sort_field: <span class='config_val'>";
echo '<select name=sort_field style="vertical-align: middle">';
foreach(array('no', 'name', 'tel-cell', 'tel-cell-pref', 'tel-home', 'tel-work', 'tel-xvoice' , 'rand') as $val) {
	echo '<option';
	if($sort_field===$val) echo ' selected';
	echo '>', $val;
}
echo '</select>';
echo "</span>&nbsp;&nbsp;aggregate_cell_numbers: <span class='config_val'>";
echo '<input type=checkbox name=aggregate_cell_numbers style="width: 10px; vertical-align: middle" ';
if($aggregate_cell_numbers) echo 'checked';
echo '>';
echo "</span>&nbsp;&nbsp;kaaf8yeh: <span class='config_val'>";
echo '<select name=kaaf8yeh style="vertical-align: middle">';
echo '<option value=""';
if($kaaf8yeh==='') echo ' selected';
echo '>&nbsp;<option';
if($kaaf8yeh==='fa') echo ' selected';
echo '>fa<option';
if($kaaf8yeh==='ar') echo ' selected';
echo '>ar';
echo '</select>';
echo "</span>";
echo "&nbsp;&nbsp;Show photos: <span class='config_val'>";
echo '<input type=checkbox name=show_photos style="width: 10px; vertical-align: middle" ';
if($show_photos) echo 'checked';
echo '>';
echo "&nbsp;&nbsp;<input type=submit value=Go name=go style='width: 30px; vertical-align: middle'></fieldset></center>";

if(($num_contacts+$max_new_rows)>ini_get('max_input_vars')) {
	echo '<hr><center style="color: red" dir=ltr>';
	echo 'Warning: max_input_vars is too small! (', ini_get('max_input_vars'), ') Not all contacts can be saved. Increase max_input_vars to at least ', $num_contacts+$max_new_rows, ' in php.ini.';
	echo ' <small>(You may also need to increase post_max_size)</small>';
	echo '</center>';
}

echo '<hr style="margin-bottom: 15px">';

//-----------------

if(empty($cards)) {
	echo '<h1 align=center dir=ltr>Empty!</h1>';
	exit;
}

echo '<table border align=center id=contacts>';

echo '<tr>';

echo '<th>&nbsp;</th>';

if(!$search) echo '<th>del</th>';

foreach($fields as $val) {

	echo '<th>';
	echo $val;
	echo '</th>';

}

echo '</tr>';

$color_flag=false;
$color1='#';
$color2='#';

$pre=$cur=array();

$error_contacts=0;
$repetitive_contacts=0;

foreach($cards as $index=>$card) {

	if($color_flag=!$color_flag) echo "<tr style='background: $color1' onmouseover='highlight(this);' onmouseout='unhighlight(this);'>";
	else echo "<tr style='background: $color2' onmouseover='highlight(this);' onmouseout='unhighlight(this);'>";
	
	echo '<td align=center ';
	echo 'style="';
	if(isset($card['error'])) {
		echo 'background: red;';
		$error_contacts++;
	}
	else if(isset($card['repetitive'])) {
		echo 'background: yellow;';
		$repetitive_contacts++;
	}
	if(isset($card['aggregate_flag'])) {
		if(isset($card['error']) or isset($card['repetitive'])) echo ' border: medium solid blue';
		else echo 'background: blue';
		echo '"';
		echo ' title="Has aggregated cellphone numbers"';
	}
	else echo '"';
	echo '>';
	echo $index+1, '</td>';
		
	if(!$search) {
		echo '<td align=center>', "<input style='width: 10px' type=checkbox name=\"cards[$index][del]\" value='1'";
		echo ' class="contact';
		if(isset($card['error'])) echo ' error_contact';
		else if(isset($card['repetitive'])) echo ' repetitive_contact';
		echo '"';
		echo ' onclick="checkbox_click(event, this)">', '</td>';
	}
	
	$pre=$cur;
	$cur=array();
	
	//**************
	
	foreach($fields as $val) {
		
		echo '<td';
		require 'include/code_compare_values.php';
		echo '>';
		
		if(isset($card[$val])) {
			if($val=='name') {
				echo "<input type=text name=\"cards[$index][name]\" value=\"";
				echo $card[$val];
				echo '" >';
			}
			else if($val=='photo') {
				if($show_photos) {
					echo '<img src="data:image/jpg;base64,';
					echo base64_encode(base64_decode($card[$val]));
					echo '">';
				}
				else echo '<center>Yes</center>';
				echo "<input type=hidden name=\"cards[$index][$val]\" value=1>";
				$_SESSION[$file]['cards'][$index]['photo']=$card[$val];
			}
			else if(is_array($card[$val])) {
				$height=20*count($card[$val]);
				echo "<textarea name=\"cards[$index][$val]\" style='height: {$height}px; color: red'>";
				$flag=false;
				foreach($card[$val] as $tmp) {
					if($flag) echo "\n";
					echo $tmp;
					$flag=true;
				}
				echo '</textarea>';
			}
			else {
				echo "<textarea name=\"cards[$index][$val]\">";
				echo $card[$val];
				echo '</textarea>';
			}
			$cur[$val]=$card[$val];
		}
		else {
			if($val!='photo') echo "<textarea name=\"cards[$index][$val]\" style='color: blue'></textarea>";
			else echo '&nbsp;';
		}
		
		echo '</td>';
	
	}
	
	echo '</tr>';

}

//------------------------------

if(!$search) {

	echo "\n<script>
	new_row=$index+1+$visible_new_rows;
	last_new_row=$index+$max_new_rows;
	add_rows_count=$add_rows_count;
	</script>\n";

	echo "<script>
	error_contacts=$error_contacts;
	repetitive_contacts=$repetitive_contacts;
	</script>";

	for($i=0; $i<$max_new_rows; $i++) {

		$index++;

		echo "<tr onmouseover='highlight(this);' onmouseout='unhighlight(this);' id='new{$index}'";
		if($i>=$visible_new_rows) echo " style='display: none' ";
		echo '>';
		echo '<td align=center style="background: rgb(109,253,68)" >', $index+1, '</td>';
		echo '<td align=center>', "<input style='width: 10px' type=checkbox name=\"cards[$index][del]\" class='contact new' value='1' onclick='checkbox_click(event, this)'>", '</td>';
		echo "<input type=hidden name=\"cards[$index][new]\" value=1>";

		foreach($fields as $val) {
			echo '<td>';
			if($val=='name') echo "<input type=text name=\"cards[$index][name]\" value=\"\">";
			else if($val=='photo') echo '&nbsp;';
			else echo "<textarea name=\"cards[$index][$val]\"></textarea>";
			echo '</td>';
		}

		echo '</tr>';
		
	}

} else echo "<script>error_contacts=repetitive_contacts=0;</script>";

//------------------------------

echo '</table>';
if(!$search) {
	echo '<center dir=ltr><input type=button onclick="add_new_row();" value="Add new row';
	if($add_rows_count>1) echo 's';
	echo '">';
	echo "&nbsp;&nbsp;<button disabled onclick='toggle_all(); return false' id=toggle_all_btn>Select all contacts</button>&nbsp;&nbsp;<button disabled onclick='toggle_all_error_contacts(); return false' id=toggle_error_contacts_btn>Select all error contacts($error_contacts)</button>&nbsp;&nbsp;<button disabled onclick='toggle_all_repetitive_contacts(); return false' id=toggle_repetitive_contacts_btn>Select all repetitive contacts($repetitive_contacts)</button>&nbsp;&nbsp;<input type=submit value='Save contacts' style='margin-top: 5px'>&nbsp;&nbsp;<input type=submit value='Undo(", $undo_count, ")'";
	echo " style='margin-top: 5px; width: 70px' name='undo' ";
	if(!$undo_count) echo 'disabled';
	echo "></center>";
}
echo '</form>';

?>
<script src='js/my_alert.js'></script>
</body>
</html>
