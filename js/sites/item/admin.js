function delete_item(array, verified){
	var id = [];
	$.each(array, function(k, v){
		id.push(v.replace(/[^0-9]/g, ''));
	});
	
	if(!id.length) return false;
	
	if(!confirm(P8LANG.confirm_to_delete)) return;
	
	//var delete_hook = confirm(P8LANG.retain_hook_module_data) ? 0 : 1;
	
	$.ajax({
		url: $this_router +'-delete',
		type: 'POST',
		dataType: 'json',
		data: ajax_parameters({id: id, verified: verified === undefined ? 1 : verified, delete_hook: 0}),
		cache: false,
		beforeSend: function(){
			ajaxing({});
		},
		success: function(json){
			ajaxing({action: 'hide'});
			
			for(var i in json){
				$('#delete_'+ json[i]).parent().parent().remove();
			}
			
			request_item(PAGE);
		}
	});
	
	return false;
}

function verify_item(array, value, verified){
	verify_item_id = [];
	$.each(array, function(k, v){
		verify_item_id.push(v.replace(/[^0-9]/g, ''));
	});
	
	if(!verify_item_id.length) return false;
	verify_dialog.show();
	
}

function list_order(array, time, verified){
	if(!verified) return;
	
	up_down_id = [];
	$.each(array, function(k, v){
		up_down_id.push(v.replace(/[^0-9]/g, ''));
	});
	
	if(!up_down_id.length) return false;
	
	up_down_dialog.show();
}

function move_item(array){
	move_item_id = [];
	$.each(array, function(k, v){
		move_item_id.push(v.replace(/[^0-9]/g, ''));
	});
	
	if(!move_item_id.length) return false;
	
	dialog.show();
}

function push_item(id, cid, send_time_type, send_time){
	
	$.ajax({
		url: $this_router +'-cluster_push',
		type: 'POST',
		dataType: 'json',
		data: ajax_parameters({id: id, cid: cid, send_time_type:send_time_type, send_time:send_time}),
		cache: false,
		beforeSend: function(){
			ajaxing({});
		},
		success: function(json){
			ajaxing({action: 'hide'});
			
			alert(lang_array(P8LANG.sites.item.cluster_pushed, [json.length]));
		}
	});
}