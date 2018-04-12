//#item_

function delete_item(array, verified){
	var id = [];
	$.each(array, function(k, v){
		id.push(v.replace(/[^0-9]/g, ''));
	});
	
	if(!id.length) return false;
	
	if(!confirm(P8LANG.confirm_to_delete)) return;
	
	var delete_hook = confirm(P8LANG.retain_hook_module_data) ? 0 : 1;
	
	$.ajax({
		url: $this_router +'-delete',
		type: 'POST',
		dataType: 'json',
		data: ajax_parameters({id: id, verified: verified === undefined ? 1 : verified, delete_hook: delete_hook}),
		cache: false,
		beforeSend: function(){
			ajaxing({});
		},
		success: function(json){
			ajaxing({action: 'hide'});
			
			for(var i in json){
				$('#delete_'+ json[i]).parent().parent().remove();
			}
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

function _move_item(cid, verified){
	
	if(!cid) return false;
	
	var cat = cs.get_by_id(cid);
	
	$.ajax({
		url: $this_router +'-move',
		type: 'post',
		dataType: 'json',
		data: ajax_parameters({id: move_item_id, cid: cid, verified: verified === undefined ? 1 : verified}),
		beforeSend: function(){
			ajaxing({});
		},
		success: function(json){
			ajaxing({action: 'hide'});
			
			for(var i = 0; i < json.length; i++){
				$('#item_cat_'+ json[i]).html('<a href="'+ cat['url'] +'" target="_blank">'+ cat['name'] +'</a>');
			}
		}
	});
}

function push_item(id, cid){
	
	$.ajax({
		url: $this_router +'-cluster_push',
		type: 'POST',
		dataType: 'json',
		data: ajax_parameters({id: id, cid: cid}),
		cache: false,
		beforeSend: function(){
			ajaxing({});
		},
		success: function(json){
			ajaxing({action: 'hide'});
			
			alert(lang_array(P8LANG.cms.item.cluster_pushed, [json.length]));
		}
	});
}

function collect(id){
	id = id.replace(/[^0-9]/g, '')*1;
	if( id < 0) return false;
	$.ajax({
		url: P8CONFIG['U_controller'] + "/cms/item-favory",
		type: 'POST',
		data: ajax_parameters({request_type: 'add', id: id}),
		cache: false,
		beforeSend: function(){
			ajaxing({});
		},
		success: function(data){
			if(data == 0){
				ajaxing({text: P8LANG.cms.item.collected, action: 'hide'});
			}else if(data == 1){
				ajaxing({text: P8LANG.cms.item.collect_success, action: 'hide'});
			}else{
				ajaxing({text: P8LANG.cms.item.collect_fail, action: 'hide'});
			}
		}
	});
}

function item_operation(ele){
	var menu = $('\
	<ul style="position: absolute; border: 2px solid #09C; background-color: #ffffff; padding: 5px;">\
		<li><a router="/'+ SYSTEM +'/item-add?model='+ model +'&cid='+ item_cid +'" target="_blank">'+ P8LANG.add +'</a></li>\
		<li><a router="/'+ SYSTEM +'/item-update?id='+ item_id +'&model='+ model +'" target="_blank">'+ P8LANG.edit +'</a></li>\
		<li><a router="/'+ SYSTEM +'/item-list?id='+ item_id +'" target="_blank">'+ P8LANG.cms.item.more_operation +'</a></li>\
	</ul>\
	');
	
	$(ele).click(function(){
		var offset = $(this).offset();
		menu.toggle().css({
			left: offset.left +'px',
			top: ($(this).height() + offset.top) +'px'
		});
		
		if(!$(ele).data('shown')){
			get_admin_controller(function(c){
				menu.find('li a').each(function(){
					this.href = c + $(this).attr('router');
				});
			});
		}else{
			$(ele).data('shown', 1);
		}
	});
	
	$(document.body).append(menu);
	menu.hide();
}