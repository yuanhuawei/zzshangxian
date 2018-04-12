$(function(){

var cancel = false;
var uploads = 0;

swfu = new SWFUpload({
	flash_url : P8CONFIG.RESOURCE +'/js/swfupload/swfupload.swf',
	upload_url: P8CONFIG.URI['core']['uploader'].url +'/swfupload.php',
	post_params: {system: system, module: module, SESSION_ID: sid, thumb_width: thumb_width, thumb_height: thumb_height, content_thumb_width: cthumb_width, content_thumb_height: cthumb_height, user_agent: navigator.userAgent},
	file_size_limit : '300 MB',
	file_types : filter,
	file_types_description : 'All Files',
	file_upload_limit : upload_count < 0 ? 100 : upload_count,
	file_queue_limit : 0,
	
	button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
	button_cursor: SWFUpload.CURSOR.HAND,
	button_width: '50',
	button_height: '21',
	button_placeholder_id: 'holder',
	
	file_queued_handler: queue,
	upload_progress_handler : progress,
	upload_complete_handler: complete,
	upload_success_handler : success
});

function queue(file){
	var copy = $('#clone').clone(true).attr('id', file.id).show().insertBefore($('#files div:last'));
	
	var _this = this;
	
	copy.find('.name').find('input').change(function(){
		_this.addFileParam(file.id, '_name', this.value);
	}).focus(function(){
		this.select();
	}).attr('tabIndex', file_count++).val(file.name);
	
	copy.find('.cancel').click(function(){
		_this.cancelUpload(file.id);
		
		copy.remove();
	});
}

function progress(file, bytesLoaded, bytesTotal){
	if(cancel){
		var m = file.id.match(/(.+_)(\d+)$/);
		var prefix = m[1], file_id = parseInt(m[2]), rest = this.getStats().files_queued +1;
		
		while(rest--){
			$('#'+ prefix + file_id).fadeOut(2000, function(){ $(this).remove(); });
			file_id++;
			this.cancelUpload();
		}
		
		cancel = false;
		return;
	}
	
	var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
	
	$('#'+ file.id +' .progress').css({width: percent +'%'});
}

function complete(file){
	if(this.getStats().files_queued){
		//next file
		this.startUpload();
	}else{
		//var ss = this.getStats(), s = ''; for(var i in ss)s+=i+':'+ss[i]+'\r\n';alert(s);
		var stat = this.getStats().successful_uploads;
		uploads = stat ? stat - uploads : stat;
		if(uploads) alert(P8LANG.core.uploader.done);
		cancel = false;
	}
}

function success(file, serverData){
	//alert(serverData);
	try{
		var json = $.evalJSON(serverData);
	}catch(e){}
	
	if(!json || !json.length){
		$('#'+ file.id +' .cancel').html(P8LANG.core.uploader.fail).off('click');
		return;
	}
	
	$('#'+ file.id +' .cancel').html(P8LANG.core.uploader.done).off('click');
	
	var a = json[0];
	
	jsonp.attachments.push({
		id: a.id,
		file: a.file,
		thumb: a.thumb,
		name: a.name
	});
	
	setcookie('p8_upload_json', $.toJSON(jsonp), 0, P8CONFIG.cookie_path, P8CONFIG.base_domain);
}

$('input.cancel_btn').click(function(){
	cancel = true;
	swfu.cancelUpload();
});

});