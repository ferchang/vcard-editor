<?php

if(!isset($_GET['for'])) return;

/*echo '<pre>';
print_r($_GET);
exit;*/

$for=$_GET['for'];
$in=$_GET['in'];

$out_cards=array();

foreach($cards as $index=>$card) {
	$match_flag=false;
	if($in==='Names' or $in==='All') {
		if(isset($card['name']) and stripos($card['name'], $for)!==false) {
			$out_cards[]=$card;
			continue;
		}
		else if($in!=='All') continue;
	}
	if($in==='Numbers' or $in==='All') {
		foreach($fields as $val) {
			if(isset($card[$val]) and stripos($val, 'tel-')===0) {
				$content=$card[$val];
				if(!is_array($content)) {//not an array
					if(stripos($content, $for)!==false) {
						$out_cards[]=$card;
						break;
					}
				}
				else {//is array
					foreach($content as $number) {
						if(stripos($number, $for)!==false) {
							$out_cards[]=$card;
							$match_flag=true;
							break;
						}
					}
					if($match_flag) break;
				}
			}
		}
	}
}

$cards=$out_cards;

require 'include/code_write_search_vcards.php';

if(!$search) $file="search/$file";
header("Location: vcard_editor.php?file=$file");
exit;

?>