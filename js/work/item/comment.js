
function Comment(options){

this.iid = options.iid;
this.url = options.url;
this.callback = options.callback;
this.view_page = options.view_page || false;

this.digg = function(id, obj){
	var cookie = get_cookie('digged_'+ SYSTEM +'_comment') || ',';
	if(cookie.indexOf(','+ id +',') != -1){
		alert(P8LANG.cms.comment.digged);
		return;
	}
	
	cookie += id +',';
	set_cookie('digged_'+ SYSTEM +'_comment', cookie);
	$.ajax({
		url: this.url,
		type: 'post',
		data: {action: 'digg', id: id},
		success: function(status){
			$(obj).html(
				$(obj).html().replace(/(\d+)/g, function(s, m){return parseInt(m)+1;})
			);
		}
	});
};

this.item = function(json, copy){
	var tmp = json.quote.split(String.fromCharCode(5)),
		quote = tmp[0],
		floor_path = tmp[1],
		i = 1;
	
	if(quote.length){
		quote = quote.replace(new RegExp(String.fromCharCode(1), 'ig'), function(s){
			return '<div class="quote">';
		});
		quote = quote.replace(new RegExp(String.fromCharCode(4), 'ig'), function(s){
			return '</div>\
			</div>';
		});
		
		quote = quote.replace(new RegExp(String.fromCharCode(2) +'([^'+ String.fromCharCode(3) +']+)', 'ig'), function(s, m){
			return '<div class="postby">\
				<span class="floor">'+ (i++) +'</span>\
				<span class="author">'+ m +'</span>';
		});
		quote = quote.replace(new RegExp(String.fromCharCode(3), 'ig'), function(s){
			return '</div>\
			<div class="content">';
		});
		
		quote = '<div class="quote_wrapper" path="'+ floor_path +'">'+ quote +'</div>';
	}
	
	copy.attr('id', 'comment_'+ json.id).
	addClass('comment_item').
	find('.author').html(
		copy.find('.author').html().replace('#author#', json.username)
	);
	
	copy.find('.content').html(nl2br(quote) + '<div class="content">'+ nl2br(json.content) +'</div>');
	
	copy.find('.date').html(
		copy.find('.date').html().replace('#date#', date('Y-m-d H:i:s', json.timestamp))
	);
	
	copy.find('.button_bar').html(
		copy.find('.button_bar').html().replace(/#id#/g, json.id).
		replace('#digg#', json.digg)
	);
	
	return copy;
};

this.request = function(page){
	page = page === undefined ? 1 : intval(page);
	page = Math.max(page, 1);
	$.getJSON(this.url +'?iid='+ this.iid +'&page='+ page +'&_ajax_request=1'+ (this.view_page ? '&view_page=1' : '') +'&callback=?', this.callback);
};

}
