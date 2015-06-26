<?php

foreach($cards as $index=>$card) {
	if(
	count($card)<2 or
	!isset($card['name']) or
	$card['name']==='' or
	$card['name']==='Unnamed'
	) $cards[$index]['error']=true;
}

?>