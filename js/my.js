var tmp;
function highlight(row) {
	tmp=row.style.background;
	row.style.background="#666";
}
function unhighlight(row) {
	row.style.background=tmp;
}

function add_new_row() {
	if(new_row>last_new_row) return;
	for(i=0; i<add_rows_count; i++) {
		document.getElementById('new'+new_row).style.display='';
		new_row++;
		if(new_row>last_new_row) break;
	}
	window.scroll(0, 9999999);
}

var error_contacts_selected=false;

function toggle_all_error_contacts() {
	$('input:checkbox.error_contact').prop('checked', !error_contacts_selected);
	error_contacts_selected=!error_contacts_selected;
	$('#toggle_error_contacts_btn').text((error_contacts_selected)? 'Deselect all error contacts('+error_contacts+')':'Select all error contacts('+error_contacts+')');
}

var repetitive_contacts_selected=false;

function toggle_all_repetitive_contacts() {
	$('input:checkbox.repetitive_contact').prop('checked', !repetitive_contacts_selected);
	repetitive_contacts_selected=!repetitive_contacts_selected;
	$('#toggle_repetitive_contacts_btn').text((repetitive_contacts_selected)? 'Deselect all repetitive contacts('+repetitive_contacts+')':'Select all repetitive contacts('+repetitive_contacts+')');
}

all_contacts_selected=false;

function toggle_all() {
	//var tmp=$('input:checkbox#no_del').prop('checked');
	$('input:checkbox.contact').prop('checked', !all_contacts_selected);
	//$('input:checkbox#no_del').prop('checked', tmp);
	all_contacts_selected=!all_contacts_selected;
	$('#toggle_all_btn').text((all_contacts_selected)? 'Deselect all contacts':'Select all contacts');
}

function on_load() {

	$('#toggle_all_btn').prop('disabled', false);
	
	if(error_contacts) $('#toggle_error_contacts_btn').prop('disabled', false);
	if(repetitive_contacts) $('#toggle_repetitive_contacts_btn').prop('disabled', false);
	
	$(":text").on('click', cell_click);
	$("textarea").on('click', cell_click);

}

prev_ckeckbox=-1;
prev_ckecked=-1;

function checkbox_click(evt, obj) {
	var n=parseInt(/[0-9]{1,}/.exec(obj.name));
	if(!evt.shiftKey || prev_ckeckbox===-1) {
		prev_ckeckbox=n;
		prev_ckecked=obj.checked;
		return;
	}
	if(n>prev_ckeckbox) {
		var from=prev_ckeckbox;
		var to=n;
	}
	else {
		var from=n;
		var to=prev_ckeckbox;
	}
	for(var i=from; i<=to; i++) {
		var name='cards['+i+'][del]';
		$("input[name='"+name+"']").prop('checked', prev_ckecked);
	}
}

function cell_click(e) {
	if(!e.ctrlKey) return;
	my_alert('', e.target.value);
}
