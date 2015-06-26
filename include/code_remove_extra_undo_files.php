<?php

if($count>$max_undos) {
	$extra=$count-$max_undos;
	for($i=1; $i<=$extra; $i++) unlink("$undo_dir/$file.undo$i");
	for($i=1; $i<=$max_undos; $i++) rename("$undo_dir/$file.undo".($i+$extra), "$undo_dir/$file.undo$i");
	$count=$max_undos;
}

?>