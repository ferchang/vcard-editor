<?php

function extract_all_numbers($card) {
	
	//note that although this is named extract_all_numbers but it indeed extracts all values in all fields (including name and photo)
	
	$numbers=array();
	foreach($card as $key=>$value) {
		if(!is_array($value)) {
			$numbers[]=$value;
			continue;
		}
		foreach($value as $value2) $numbers[]=$value2;
	}

	return $numbers;
	
}

?>