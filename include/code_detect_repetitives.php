<?php

$prev_card=array('name'=>'');

require 'include/func_extract_all_numbers.php';

foreach($cards as $index=>$card) {
	if(isset($card['error'])) continue;
	if($card['name']===$prev_card['name']) {
		$prev_numbers=extract_all_numbers($prev_card);
		$current_numbers=extract_all_numbers($card);
		if(count(array_diff($current_numbers, $prev_numbers))===0) $cards[$index]['repetitive']=true;
	}
	$prev_card=$card;
}

?>