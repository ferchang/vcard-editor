<?php

if(empty($_POST)) return;

require 'func_write_vcard_field.php';
	
$output='';
foreach($_POST['cards'] as $key=>$card) {
	if(isset($card['new'])) {
		unset($card['new']);
		$empty=true;
		foreach($card as $val) if($val!=='') {
			$empty=false;
			break;
		}
		if($empty) continue;
	}
	if(isset($card['del'])) continue;
	$output.="BEGIN:VCARD\r\nVERSION:2.1\r\n";
	if(isset($card['name']) and trim($card['name'])!=='') {
		if(!$output_quoted_printable) {
			$output.='N:;';
			$output.=$card['name'].";;;\r\n";
			$output.='FN:';
			$output.=$card['name']."\r\n";
		}
		else {
			$output.='N;CHARSET='.strtoupper($charset).';ENCODING=QUOTED-PRINTABLE:;';
			$output.=quoted_printable_encode($card['name']).";;;\r\n";
			$output.='FN;CHARSET='.strtoupper($charset).';ENCODING=QUOTED-PRINTABLE:';
			$output.=quoted_printable_encode($card['name'])."\r\n";
		}
	}
	if($preserve_photos and isset($card['photo'])) {
		$output.='PHOTO;ENCODING=BASE64;JPEG:';
		$output.=$_SESSION[$file]['cards'][$key]['photo'];
		$output.="\r\n";
	}
	$tmp=$fields;
	unset($tmp['FN;CHARSET=UT'], $tmp['PHOTO;ENCODIN']);
	foreach($tmp as $field) if(isset($card[$field]) and trim($card[$field])!=='') write_vcard_field($field, $card[$field], $output);
	$output.="END:VCARD\r\n";
}

require 'include/code_save_undo_file.php';

file_put_contents("vcards/$file", $output);

header("Location: vcard_editor.php?file=$file");
exit;

?>