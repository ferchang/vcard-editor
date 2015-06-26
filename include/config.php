<?php

$fields=array('FN;CHARSET=UT'=>'name', 'TEL;CELL'=>'tel-cell', 'TEL;CELL;PREF'=>'tel-cell-pref', 'TEL;HOME'=>'tel-home', 'TEL;WORK'=>'tel-work', 'TEL;X-VOICE'=>'tel-xvoice', 'PHOTO;ENCODIN'=>'photo');

$charsets=array('windows-1256', 'utf-8');//first item is the default (used when charset is not detected automatically and is not already specified by user)

$save_quoted_printable_encode='';//yes, no, empty string (follow input file)

$max_undos=20;//0 to disable

$sort_field='no';
//one of the values in the $fields array; like name, tel-cell, ...
//special values: no: no sort / rand: shuffle (needed for testing purposes)

$sort_dir=SORT_ASC;

$aggregate_cell_numbers=false;
//whether to aggregate all cell/mobile phone numbers in one field tel-cell.
//note: this works for mobile phone numbers of iran because i wrote the regex for them.

$kaaf8yeh='fa';
//convert kaaf and yeh letters to fa (farsi/persian) or ar (arabic) kaaf and yeh.
//note: currently doesnt work with windows-1256 charset.

$show_photos=true;

$preserve_photos=true;
//whether to preserve photos in contacts.
//set to false to remove photos from all contacts when saving.

$max_new_rows=10;
//maximum number of new rows that can be added to the page
//note: new rows are used for adding new contacts

$visible_new_rows=1;
//number of new rows that are visible by default (i.e. without pressing the Add button)

$add_rows_count=1;
//specifies how many rows are added to the page each time the Add button is pressed

?>