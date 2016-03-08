<?php

if($sort_field=='no' or empty($cards)) return;

if($sort_field=='rand') {
	shuffle($cards);
	return;
}

foreach($cards as $index => $card) {
	if(isset($card[$sort_field])) $sort1[$index]=$card[$sort_field];
	else $sort1[$index]='';
	if(isset($card['name'])) $sort2[$index]=$card['name'];
	else $sort2[$index]='';
}

array_multisort($sort1, $sort_dir, $sort2, $cards);

?>