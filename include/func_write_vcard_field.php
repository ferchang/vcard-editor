<?php

function write_vcard_field($name, $value, &$output) {
	
	$fields=array('tel-cell'=>'TEL;CELL:', 'tel-cell-pref'=>'TEL;CELL;PREF:', 'tel-home'=>'TEL;HOME:', 'tel-work'=>'TEL;WORK:', 'tel-xvoice'=>'TEL;X-VOICE:', 'photo'=>'PHOTO;ENCODING=BASE64;JPEG:');
	
	if(is_array($value)) $value=implode("\n", $value);
	
	if(strpos($value, "\n")===false) $output.="{$fields[$name]}$value\r\n";
	else {
		$value=str_replace("\r", '', $value);
		$value=explode("\n", $value);
		foreach($value as $val) if(trim($val)!=='') $output.="{$fields[$name]}$val\r\n";
	}
}

?>