<?php

require 'func_write_vcard_field.php';

//echo '<pre>';
//print_r($cards);
//exit;

$output='';
foreach($cards as $key=>$card) {
	$output.="BEGIN:VCARD\r\nVERSION:2.1\r\n";
	if(isset($card['name']) and $card['name']!=='') {
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
	if(isset($card['photo'])) {
		$output.='PHOTO;ENCODING=BASE64;JPEG:';
		$output.=$card['photo'];
		$output.="\r\n";
	}
	$tmp=$fields;
	unset($tmp['FN;CHARSET=UT'], $tmp['PHOTO;ENCODIN']);
	foreach($tmp as $field) if(isset($card[$field]) and $card[$field]!=='') write_vcard_field($field, $card[$field], $output);
	$output.="END:VCARD\r\n";
}

$search_dir='vcards/search';

if(!file_exists($search_dir)) mkdir($search_dir);

file_put_contents("$search_dir/".basename($file), $output);

?>