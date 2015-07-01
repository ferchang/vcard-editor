<?php

$pat='/BEGIN:VCARD.*?END:VCARD/s';

preg_match_all($pat, $contents, $matches);

$num_contacts=count($matches[0]);

$cards=array();

foreach($matches[0] as $key=>$val) {

	$pat='/([^:]+):([^:]+)\r?\n/';

	preg_match_all($pat, $val, $matches);

	if(!in_array('FN;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE', $matches[1])) {
		foreach($matches[1] as $key=>$val) if($val==='FN' or $val==='FN;CHARSET=UTF-8') {
			unset($matches[1][$key]);
			$matches[1][$key]='FN;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE';
			break;
		}
	}

	if(!in_array('FN;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE', $matches[1])) {
		foreach($matches[1] as $key=>$val) if($val==='N' or $val==='N;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE') {
			unset($matches[1][$key]);
			$matches[1][$key]='FN;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE';
			break;
		}
	}

	$tmp1=array();
	$tmp2=array();

	foreach($matches[1] as $key=>$val) {
		$val=substr($val, 0, 13);
		if(!in_array($val, array_keys($fields))) continue;
		$tmp1[]=$fields[$val];
		$tmp=preg_replace('/^(\+|00)98/', '0', $matches[2][$key]);
		$tmp2[]=$tmp;
	}
	$matches[1]=$tmp1;
	$matches[2]=$tmp2;
	
	$counts=array_count_values($matches[1]);
	foreach($counts as $key2=>$val2) if($val2>1) {
		$rkey=$key2;
		$rvals=array();
		foreach($matches[1] as $key2=>$val2) {
			if($val2==$rkey) {
				$rvals[]=$matches[2][$key2];
				unset($matches[1][$key2], $matches[2][$key2]);
			}
		}
		$matches[1][]=$rkey;
		$matches[2][]=$rvals;
	}

	if(!empty($matches[1])) $cards[]=array_combine($matches[1], $matches[2]);
	else $cards[]='';

}

?>