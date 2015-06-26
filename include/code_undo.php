<?php

if(!$max_undos) return;

$undo_dir='vcards/undo';

$undo_count=count(glob("$undo_dir/$file.undo*"));

if(!$undo_count) return;

require 'include/code_remove_extra_undo_files.php';

rename("$undo_dir/$file.undo$undo_count", "vcards/$file");

file_put_contents($info_file, md5(file_get_contents("vcards/$file")));

header("Location: vcard_editor.php?file=$file");
exit;

?>