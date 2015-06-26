<?php

if(!$max_undos) return;

$undo_dir='vcards/undo';

$undo_count=count(glob("$undo_dir/$file.undo*"));

if(!file_exists($undo_dir)) mkdir($undo_dir);

require 'include/code_remove_extra_undo_files.php';

if($undo_count==$max_undos) {
	for($i=2; $i<=$max_undos; $i++) rename("$undo_dir/$file.undo$i", "$undo_dir/$file.undo".($i-1));
	$undo_count=$max_undos-1;
}

$undo_count++;

file_put_contents("$undo_dir/$file.undo$undo_count", $contents);

file_put_contents($info_file, md5($output));

?>