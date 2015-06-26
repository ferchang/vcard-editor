<?php

if(strpos($contents, 'QUOTED-PRINTABLE')!==false) $input_quoted_printable=true;
else $input_quoted_printable=false;

if(isset($_GET['charset'])) {
	$charset=$_GET['charset'];
	$charset_detection_method='get';
	$_SESSION[basename($file)]['charset']=$charset;
	return;
}

if(isset($_SESSION[basename($file)]['charset'])) {
	$charset=$_SESSION[basename($file)]['charset'];
	$charset_detection_method='sess';
	return;
}

if($input_quoted_printable) {
	if(strpos($contents, 'CHARSET=WINDOWS-1256')!==false) {
		$charset='windows-1256';
		$charset_detection_method='file';
		$contents=str_replace('CHARSET=WINDOWS-1256', 'CHARSET=UTF-8', $contents);//ok a dirty hack! my program code is hardcoded with CHARSET=UTF-8
		return;
	}
	if(strpos($contents, 'CHARSET=UTF-8')!==false) {
		$charset='utf-8';
		$charset_detection_method='file';
		return;
	}
}

$charset=$charsets[0];
$charset_detection_method='default';

?>