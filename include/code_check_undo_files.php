<?php

if($search) return;

if(!$max_undos) return;

$undo_dir='vcards/undo';

$info_file="$undo_dir/$file.info";

if(file_exists($info_file) and file_get_contents($info_file)!==md5($contents)) {
	foreach(glob("$undo_dir/$file.undo*") as $tmp) unlink($tmp);
	unlink($info_file);
}

$undo_count=count(glob("$undo_dir/$file.undo*"));

?>