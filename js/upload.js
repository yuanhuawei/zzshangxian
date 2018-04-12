/**
* @example
upload = new P8_Upload({
	upload_url: 'upload_url',
	browse_url: 'browse_url',
	jsonp_url: 'jsonp_url',
	element: {
		src: $('#ele'),
		attribute: 'value'
	},
	param: {
		filter: {
			gif: 0,
			jpg: 1024,	//1K
			...
		},
		count: 2,	//max 2 files
		return_thumb: true,
		thumb_width: 0,
		thumb_height: 0,
	},
	callback: function(json){
		
	}
});
**/
function P8_Upload(options){

this.element = options.element || null;

this.callback = options.callback || null;

//upload url
this.upload_url = options.upload_url || P8CONFIG.URI['core']['uploader'].controller +'-upload';
//browse url
this.browse_url = options.browse_url || P8CONFIG.URI['core']['uploader'].controller +'-list';
this.delete_url = options.delete_url || P8CONFIG.URI['core']['uploader'].controller +'-delete';
//jsonp callback url
this.jsonp_url = options.jsonp_url || P8CONFIG.url +'/api/upload_jsonp.php';
this.param = '';

this.dialog = new P8_Dialog({
	width: 700,
	height: 420,
	button: true,
	ok: function(){
		if(_this._cutting){
			this.content.empty().append(_this.iframe);
			_this._cutting = false;
		}
		_this.jsonp();
	},
	cancel: function(){
		if(_this._cutting){
			this.content.empty().append(_this.iframe);
			_this._cutting = false;
		}
	}
});

this.iframe = $('<div><iframe src="about:blank" width="100%" height="340" frameborder="0" border="0" marginwidth="0" marginheight="0"></iframe></div>');
this.dialog.content.append(this.iframe);
this._cutting = false;

var param = options.param || {};


this.param += 'system='+ SYSTEM +'&module='+ MODULE;

this.param += ajax_parameters(param);



if(param.return_thumb !== undefined){
	this.param += '&thumb=1';
	this.return_thumb = true;
}

if(param.return_cthumb !== undefined){
	this.return_cthumb = true;
}

var _this = this;

this.set_element = function(json){
	if(json.attachments !== undefined){
		var ret;
		
		if(this.return_thumb && json.attachments[0].thumb > 0){
			ret = json.attachments[0].file +'.thumb.jpg';
		}else if(this.return_cthumb && json.attachments[0].thumb == 2){
			ret = json.attachments[0].file +'.cthumb.jpg';
		}else{
			ret = json.attachments[0].file;
		}
		$(_this.element.src).attr(_this.element.attribute, ret);
	}
};

this.browser = function(){
	this.dialog.set_title(P8LANG.browse);
	this.dialog.content.find('iframe').attr('src', this.browse_url +'?'+ this.param);
	this.dialog.show();
};

this.uploader = function(){
	this.dialog.set_title(P8LANG.upload);
	this.dialog.content.find('iframe').attr('src', this.upload_url +'?'+ this.param);
	this.dialog.show();
};

this.capture = function(){
	this.dialog.set_title(P8LANG.capture);
	this.dialog.content.find('iframe').attr('src', this.upload_url +'?'+ this.param + '&only=capture');
	this.dialog.show();
};

this.add_param = function(obj){
	this.param += ajax_parameters(obj);
};

this.choseup = function(){
	this.dialog.element.css({
		width: '300px',
		height: '200px'
	});
	this.dialog.content.height(30);
	this.dialog.button_bar.hide();
	this.dialog.set_title(P8LANG.core.uploader.select);
	this.chosebar = $('<div class="chosebar"><input type="button" value="'+ P8LANG.localup +'"  class="up">&nbsp;&nbsp;&nbsp;<input type="button" value="'+ P8LANG.chosedone +'"  class="br">&nbsp;&nbsp;&nbsp;<input type="button" value="'+ P8LANG.capture +'"  class="wb"></div>');
	this.dialog.content.html(this.chosebar);
	this.dialog.show();
	//on up
	$('.up', this.chosebar).click(function(){
		_this.chose('uploader');
	});
	
	//on br
	$('.br', this.chosebar).click(function(){
		_this.chose('browser');
	});
	//web
	$('.wb', this.chosebar).click(function(){
		_this.chose('capture');
	});
};


this.chose = function(b){
	this.dialog.content.append(this.iframe);
	this.dialog.element.css({
		width: '700px',
		height: '420px'
	});
	this.dialog.content.height(340);
	this.dialog.button_bar.show();
	if(b=='uploader')this.uploader();
	if(b=='browser')this.browser();
	if(b=='capture')this.capture();
};
this.image_cut = function(){
	
	var url = this.element.src.val();
	if(!url.length) return;
	url = url.replace(/\.thumb\.jpg/i, '');
	
	var w = window.open(P8CONFIG.controller +'/core/uploader-image_cut?url='+ urlencode(url) +'&system=' + SYSTEM +'&module='+ MODULE);
	
	this._cutting = true;
	
	this.dialog.show();
	this.dialog.content.html(P8LANG.core.uploader.click_to_get_cut_image);
	
	return;
};

this._callback = function(json){
	if(_this.element){
		_this.set_element(json);
	}
	
	if(_this.callback){
		_this.callback(clone(json));
	}
	
	P8_Upload.callback(json);
	
	setcookie('p8_upload_json', '', -1, '/', P8CONFIG.base_domain);
};

this.jsonp = function(){
	$.getJSON(this.jsonp_url +'?callback=?', this._callback);
};

}

P8_Upload.uploader_element = null;
P8_Upload.browser_element = null;

P8_Upload.callback = function(json){
	if(json.attachments !== undefined && json.attachments.length){
		
		if(MODULE && json.action == 'upload'){
			P8_Upload.queue(json.attachments);
		}
	}
};

//delete
P8_Upload.del = function(form_submit){
	var cookie = get_cookie('uploaded_attachments');
	
	if(cookie !== undefined){
		var att = cookie[attachment_hash];
		if(att !== undefined && !form_submit){
			set_cookie('uploaded_attachments['+ attachment_hash +']', '', -1, document.base_domain);
			
			att = att.split(',');
			
			var form = $('<form method="post" action="'+ P8CONFIG.URI['core']['uploader'].controller +'-delete" target="delete_attachment"></form>');
			var iframe = $('<iframe name="delete_attachment" style="display: none; height: 0px; width: 0px;"></iframe>');
			$(document.body).prepend(form).prepend(iframe);
			
			form.append($('<input type="hidden" name="system" value="'+ SYSTEM +'" />'));
			for(var i = 0; i < att.length; i++){
				form.append($('<input type="hidden" name="id[]" value="'+ att[i] +'" />'));
			}
			form.get(0).submit();
		}
	}
};

P8_Upload.queue = function(json){
	if(!attachment_hash) return;
	
	var cookie = get_cookie('uploaded_attachments') || {};
	var str = cookie[attachment_hash] || '';
	for(var i = 0; i < json.length; i++){
		str += json[i].id +',';
	}
	//cookie for php
	set_cookie('uploaded_attachments['+ attachment_hash +']', str, 0, document.base_domain);
};

P8_Upload.verify_ext = function(file, filter){
	var ext = file.substr(file.lastIndexOf('.') +1, file.length).toLowerCase();
	
	return filter[ext] != undefined ? ext : '';
};

P8_Upload.verify_size = function(file, ext, filter){
	var tmp_img = new Image();
	
	tmp_img.src = file;
	var max_size = parseInt(filter[ext]);
	if(max_size > 0 && tmp_img.fileSize > max_size){
		return false;
	}
	return true;
};

P8_Upload.verify = function(file, new_file, append_to){
	var filename = file.value;
	
	var ext = P8_Upload.verify_ext(filename, filter_json);
	
	if(!ext){
		alert(P8LANG.core.uploader.type_denied);
		
		++file_id;
		
		$(file).replaceWith(new_file);
		return '';
	}
	
	if(!P8_Upload.verify_size(filename, ext, filter_json)){
		alert(P8LANG.core.uploader.oversize);
		
		++file_id;
		
		$(file).replaceWith(new_file);
		return '';
	}
	
	if(++file_count < upload_count){
		$(append_to).append(new_file);
	}
};