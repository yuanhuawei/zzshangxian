
document.onselectstart = function(){
	return false;
};

var last_file = null;
var multi = false;
var files = [];

function _goto(s, m){
	s = s || 'core';
	m = m || '';
	
	var url = window.location.href;
	url = url.replace(/system=([^&]*)/g, 'system='+ s).
	replace(/module=([^&]*)/g, 'module='+ m).
	replace(/page=([^&]*)/g, '');
	
	window.location.href = url;
}

function get_file_info(file){
	var info = {
		id: $(file).attr('id').replace(/[^0-9]/g, ''),
		remote: $(file).attr('alt'),
		thumb: parseInt($(file).find('b').html()),
		name: $(file).find('.name').html(),
		size: parseInt($(file).attr('size'))
	};
	info.file = (info.remote == 0 ? attachment_url : remote_attachment_urls[info.remote]) +'/'+ $(file).find('em').html();
	
	return info;
}



function view(e){
	var info = get_file_info(e.data.a);
	$(this).find('a').attr('href', info.file).click();
}

function rename(e){
	var a = e.data.a;
	
	var name = $.trim(prompt(P8LANG.core.uploader.input_rename_file_name, $(a).find('.name').html()));
	
	if(name.length && name != $(a).find('.name').html()){
		var _this = a;
		
		$.ajax({
			url: $this_router +'-rename',
			type: 'post',
			data: {system: system, id: a.id.replace(/[^0-9]/g, ''), name: name},
			beforeSend: function(){
				ajaxing({});
			},
			success: function(status){
				ajaxing({action: 'hide'});
				
				if(status == 1){
					$(_this).attr('title', name).find('.name').html(name);
				}
			}
		});
	}
	
	return false;
}

function del(e){
	var a = e.data.a;
	
	if(confirm(P8LANG.confirm_to_delete)){
		$.ajax({
			url: $this_router +'-delete',
			type: 'post',
			dataType: 'json',
			data: {system: system, id: a.id.replace(/[^0-9]/g, '')},
			beforeSend: function(){
				ajaxing({});
			},
			success: function(json){
				ajaxing({action: 'hide'});
				
				for(var i = 0; i < json.length; i++){
					$('#file_'+ json[i]).remove();
				}
			}
		});
	}
}

$('#items a').each(function(i){
	
	var info = get_file_info(this);
	
	$(this).find('div.size').html(Math.ceil(info.size / 1024) + ' KB');
	
	if(/\.(jpg|jpeg|gif|png)$/i.test(info.file)){
		
		$(this).find('.icon').css({
			background: 'url('+ info.file + (info.thumb ? '.thumb.jpg' : '') +') no-repeat'
		});
		
	}else{
		var reg = {
			doc: /\.doc$/i,
			swf: /\.swf$/i,
			zip: /\.(zip|rar|gz|tgz|bz2)$/i,
			media: /\.(rm|rmvb|avi|wmv|mp3|mp4|mpg|mpeg)$/i
		};
		
		var ext = 'default';
		
		for(var i in reg){
			if(reg[i].test(info.file)){
				ext = i;
				break;
			}
		}
		
		$(this).find('.icon').css({
			background: 'url('+ SKIN +'uploader/'+ ext +'.gif) no-repeat scroll 50% 50%'
		});
	}
	
	$(this).click(function(){
		
		var info = get_file_info(this);
		//info.name = utf8_encode(info.name);
		
		var this_file = $(this);
		var json = {action: 'browse', attachments: []};
		
		if(multi){
			files.push({id: info.id, file: info.file, thumb: info.thumb, size: info.size, name: info.name});
			
			if(this_file.hasClass('selected')){
				this_file.removeClass('selected');
				
				files = [];
				$('#items a.selected').each(function(i){
					var _info = get_file_info(this);
					//_info.name = utf8_encode(_info.name);
					
					files[i] = {
						id: _info.id,
						file: _info.file,
						thumb: _info.thumb,
						size: _info.size,
						name: _info.name
					};
				});
			}else{
				
				this_file.addClass('selected');
			}
		}else{
			$('#items a.selected').removeClass('selected');
			
			if(this_file.hasClass('selected')){
				files = [];
			}else{
				files = [{id: info.id, file: info.file, thumb: info.thumb, size: info.size, name: info.name}];
				
				this_file.addClass('selected');
			}
			
		}
		
		json.attachments = files;
		
		setcookie('p8_upload_json', $.toJSON(json), 0, P8CONFIG.cookie_path, P8CONFIG.base_domain);
		
		return false;
	}).
	dblclick(function(){
		
	}).
	bind('contextmenu', function(){
		
		var offset = $(this).offset();
		
		$('#menu').show().css({
			left: (offset.left + 5) +'px',
			top: (offset.top + 5) +'px'
		}).find('li:eq(0)').off('click', view).on('click', {a: this}, view);
		
		$('#menu').find('li:eq(1)').off('click', rename).on('click', {a: this}, rename);
		$('#menu').find('li:eq(2)').off('click', del).on('click', {a: this}, del);
		
		return false;
		
		return false;
	});
	
});

$(function(){
	
	$(document).keydown(function(e){
		//multi select press 
		multi = e.keyCode == 17 ? true : false;
	}).keyup(function(e){
		//multi select press 
		multi = false;
	}).mouseup(function(){
		$('#menu').hide();
	});
});