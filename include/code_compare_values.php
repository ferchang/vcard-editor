<?php

if(isset($card[$val])) {
	
	$border_color='';
	
	foreach($pre as $ii=>$tmp) {

		$found=false;
		
		if($tmp==$card[$val]) {
			$found=true;
		}
		else if(is_array($tmp) and !is_array($card[$val])) {
			foreach($tmp as $vv) if($vv==$card[$val]) {
				$found=true;
				break;
			}
		}
		else if(is_array($card[$val]) and !is_array($tmp)) {
			foreach($card[$val] as $vv) if($vv==$tmp) {
				$found=true;
				break;
			}
		}
		else if(is_array($card[$val]) and is_array($tmp)) {
			foreach($tmp as $vv) foreach($card[$val] as $vvv) if($vv==$vvv) {
				$found=true;
				break;
			}
		}
		
		if($found) {
			if($ii==$val) {
				$border_color='red';
				break;
			}
			else $border_color='orange';
		}
		
	}
	
	if($border_color) echo " style='border: medium solid $border_color' ";
	
}

?>