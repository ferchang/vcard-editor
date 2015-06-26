<?php

foreach($cards as $index=>$card) {

	if(isset($card['name'])) {
		$card['name']=quoted_printable_decode($card['name']);
		$card['name']=kaaf8yeh($card['name']);
		$card['name']=preg_replace('/(?<!;);(?!;)/', ' ', $card['name']);
		$card['name']=str_replace(';', '', $card['name']);
		$card['name']=trim($card['name']);
		$cards[$index]['name']=$card['name'];
	}
	
}

?>