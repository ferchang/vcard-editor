<?php

function kaaf8yeh($str) {

	global $kaaf8yeh;
	
	if($kaaf8yeh=='fa') $str=str_replace(array('ي', 'ى', 'ك'), array('ی', 'ی', 'ک'), $str);//ARABIC LETTER YEH, ARABIC LETTER ALEF MAKSURA, ARABIC LETTER KAF to persian
	else if($kaaf8yeh=='ar') $str=str_replace(array('ی', 'ک'), array('ي', 'ك'), $str);
	else if($kaaf8yeh!=='') exit('Error: Invalid $kaaf8yeh value!');
	
	return $str;
	
}

?>