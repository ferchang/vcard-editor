<?php

if(!$aggregate_cell_numbers) return;

foreach($cards as $index=>$card) {

	foreach($fields as $val) {

		if($val!='tel-cell' and !empty($card[$val]) and stripos($val, 'tel-')===0) {
			$content=$card[$val];
			$mob_pat='/^09[0-9]{8,10}$/';
			if(!is_array($content)) {
				if(preg_match($mob_pat, $content)) {
					$card['aggregate_flag']=true;
					if(empty($card['tel-cell'])) $card['tel-cell']=$content;
					else if(is_array($card['tel-cell'])) $card['tel-cell'][]=$content;
						 else $card['tel-cell']=array($card['tel-cell'], $content);
					unset($card[$val]);
				}
			}
			else {
				foreach($content as $index2=>$number) {
					if(preg_match($mob_pat, $number)) {
						$card['aggregate_flag']=true;
						if(empty($card['tel-cell'])) $card['tel-cell']=$number;
						else if(is_array($card['tel-cell'])) $card['tel-cell'][]=$number;
							 else $card['tel-cell']=array($card['tel-cell'], $number);
						unset($card[$val][$index2]);
					}
				}
				if(count($card[$val])===0) unset($card[$val]);
			}
		}

	}

	$cards[$index]=$card;

}

?>