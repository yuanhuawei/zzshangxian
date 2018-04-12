
function Comment(options){

this.iid = options.iid;
this.url = options.url;
this.callback = options.callback;
this.view_page = options.view_page || false;
this.quotes = {};
this.items = {};
var _this = this;

this.digg = function(id, obj){
	var cookie = get_cookie('digged_'+ SYSTEM +'_comment') || ',';
	if(cookie.indexOf(','+ id +',') != -1){
		alert(P8LANG.office.comment.digged);
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
	
	var quotes = json.quote.split(',').reverse(),
		id = json.id,
		repeat = false;
	
	for(var i in this.items){
		if(
			this.items[id] && quotes.length > 1 &&
			this.items[i].quote.indexOf(this.items[id].quote +',') == 0 &&
			this.items[i].quote != this.items[id].quote
		){
			repeat = true;
			break;
		}
	}
	
	var repeat_hide = $(repeat ? this._quote(quotes.slice(quotes.length -1), 1, true) :  '<div></div>');
	repeat_hide.find('.repeat').
		click(function(){
			quote.show();
			repeat_hide.hide();
		});
	
	var quote = $(this._quote(quotes, quotes.length));
	var wrapper = $('<div class="quote_wrapper"></div>').
		append(repeat_hide).
		append(quote[repeat ? 'hide' : 'show']());
	
	copy.attr('id', 'comment_'+ json.id).
		addClass('comment_item').
		find('.author').html(
			copy.find('.author').html().replace('__author__', json.username)
		);
	
	copy.find('.content').
		append(wrapper).
		append($('<div class="content">'+ nl2br(json.content) +'</div>'));
	
	copy.find('.date').html(
		copy.find('.date').html().replace('__date__', date('Y-m-d H:i:s', json.timestamp))
	);
	
	copy.find('.button_bar').html(
		copy.find('.button_bar').html().replace(/__id__/g, json.id).
		replace('__digg__', json.digg)
	);
	
	return copy;
};

this._quote = function(quote_path, floor, repeat){
	var id = quote_path.shift();
	if(!id) return '<div></div>';
	
	var quote_item = this.quotes[id];
	
	var quote = [
		'<div class="quote">',
			this._quote(quote_path, floor -1),
			'<div class="postby">',
				'<span class="floor">', floor, '</span>',
				'<span class="author">',
					(quote_item ? lang_array(P8LANG[SYSTEM].comment.quote_who, [quote_item.username]) : ''),
				'</span>',
			'</div>',
			'<div class="content">',
				nl2br(quote_item ? quote_item.content : P8LANG[SYSTEM].comment.deleted),
			'</div>',
		'</div>'].join('');
	
	if(repeat){
		quote = ['<div class="quote">', quote,
				'<div class="repeat" style="cursor: pointer;">',
					P8LANG[SYSTEM].comment.repeat,
				'</div>',
			'</div>'].join('');
	}
	
	return quote;
};

this._callback = function(json){
	
	_this.quotes = json.quotes;
	_this.items = json.items;
	
	_this.callback(json);
};

this.request = function(page){
	page = page === undefined ? 1 : intval(page);
	page = Math.max(page, 1);
	$.getJSON(
		this.url +'?iid='+ this.iid +'&page='+ page +'&_ajax_request=1'+ (this.view_page ? '&view_page=1' : '') +'&callback=?',
		this._callback);
};

}