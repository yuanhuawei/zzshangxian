function label_add_order_by(original, target, selected, checked){
	if(selected){
		if($(original).find('div select option[value='+ selected +']').length == 0){
			return;
		}
	}
	var obj = $(original).find('div').clone().appendTo(target).show();
	
	_order_by_offset++;
	
	//god damn ie6
	var select = $('<select name="option[order_by]['+ _order_by_offset +']"></select>');
	obj.find('select option').appendTo(select);
	
	obj.find('select').replaceWith(select);
	var check1 = $('<input type="radio" name="option[order_by_desc]['+ _order_by_offset +']" value="1" />');
	var check2 = $('<input type="radio" name="option[order_by_desc]['+ _order_by_offset +']" value="0" />');
	
	obj.find('input[type=radio][value=1]').replaceWith(check1);
	obj.find('input[type=radio][value=0]').replaceWith(check2);
	if(!checked){
		obj.find('input[type=radio][value=1]').prop('checked', true);
	}
	
	if(selected){
		obj.find('select').find('option[value='+ selected +']').attr('selected', true);
		obj.find('input[type=radio][value='+ checked +']').prop('checked', true);
	}
}

function label_delete_order_by(obj){
	if($(obj).parent().parent().attr('id') == 'order_by'){
		return;
	}
	
	$(obj).parent().remove();
}

function _change_roles(system){
	
	//if(roles_json[system] !== undefined){
		$('#allowed_roles').attr('length', 1);
		
		for(var i in roles_json){
			$('<option value="'+ roles_json[i].id +'">'+ roles_json[i].name +'</option>').
				attr('selected', allowed_roles_json[roles_json[i].id] !== undefined ? true : false).
				appendTo($('#allowed_roles'));
		}
	//}
}

function explain_sql(){
	$.ajax({
		url: $this_url +'?action=explain',
		type: 'post',
		cache: false,
		data: $('#form').serialize(),
		beforeSend: function(){
			ajaxing({});
		},
		success: function(data){
			ajaxing({action: 'hide'});
			$('#explain').html(data);
		}
	});
}

function preview(){
	$.ajax({
		url: $this_url +'?action=preview',
		type: 'post',
		cache: false,
		data: $('#form').serialize(),
		beforeSend: function(){
			ajaxing({});
		},
		success: function(data){
			ajaxing({action: 'hide'});
			$('#explain').html(data);
		}
	});
}