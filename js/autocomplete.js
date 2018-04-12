/**
html structure
<div>
	<ul>
		<li>item1</li>
		<li>item2</li>
		<li>item ...</li>
	</ul>
</div>

css
.container {}	div
.list{}			ul
.item{}			li
.item_focus{}
**/
function P8_Autocomplete(options){

this.className = options.className || '';
this.input = $(options.input);
//url format: http://www.url.com/xxx.php?keyword=###
this.url = options.url || '';
this.response_type = options.response_type || 'json';
this.callback = options.callback || null;
this.item_callback = options.item_callback || null;

this.element = $('<div class="'+ this.className +'"><ul class="list"></ul></div>');
this.list = this.element.find('ul');

this._current_item = null;
this._triggered = false;
this._last_item = null;
this._timeout = null;
this._key_interval = null;
this.keyword = '';
this.last_keyword = '';
this.last_value = '';
this.zIndex = options.zIndex || 100002;

this.offset = -1;
this.item_length = 0;
this._item_height = 0;
this._scale = 0;

$(document.body).append(this.element.hide().css({zIndex: this.zIndex}));

var _this = this;

this.input.attr('autocomplete', 'off').
keyup(function(e){
	var key = e.keyCode;
	
	switch(key){
	case 38://up
		if(_this._key_interval) clearInterval(_this._key_interval);
	break;
	
	case 40://down
		if(_this._key_interval) clearInterval(_this._key_interval);
	break;
	
	case 13://enter
		if(_this._current_item === null) return;
		
		_this._callback(_this._current_item);
	break;
	
	case 27://ESC
		_this.display(false);
	break;
	
	default:
		_this._trigger();
	}
}).
keydown(function(e){
	var key = e.keyCode;
	
	switch(key){
	
	case 38://up
		if(_this._key_interval) clearInterval(_this._key_interval);
		
		_this.move_up();
		
		_this._key_interval = setInterval(function(){_this.move_up();}, 300);
	break;
	
	case 40://down
		if(_this._key_interval) clearInterval(_this._key_interval);
		
		_this.move_down();
		
		_this._key_interval = setInterval(function(){_this.move_down();}, 300);
	break;
	
	}
}).
focus(function(){
	_this.display(true);
}).
blur(function(){
	_this.display(false);
});

this.move_up = function(){
	if(this.item_length == 0) return;
	
	if(this._current_item === null){
		var offset = this.item_length -1;
	}else{
		var offset = this._current_item.data('offset') -1;
	}
	
	this.move_to(offset);
	this.list.attr('scrollTop', Math.ceil(this._scale * offset));
};

this.move_down = function(){
	if(this.item_length == 0) return;
	
	if(this._current_item === null){
		var offset = 0;
	}else{
		var offset = this._current_item.data('offset') +1;
	}
	
	this.move_to(offset);
	this.list.attr('scrollTop', Math.ceil(this._scale * offset));
};

this.move_to = function(offset){
	offset = offset > this.item_length -1 ? 0 : offset;
	offset = offset < 0 ? this.item_length -1 : offset;
	
	if(this._last_item) this._last_item.removeClass('item_focus');
	
	this._current_item = this.list.find('li:eq('+ offset +')');
	
	this._current_item.addClass('item_focus');
	this.offset = offset;
	
	this._last_item = this._current_item;
};

this._trigger = function(){
	if(this._timeout){
		clearTimeout(this._timeout);
	}
	this._triggered = false;
	
	this.keyword = $.trim(this.input.val());
	if(!this.keyword.length){
		this.deploy([]);
		this.last_keyword = '';
		return;
	}
	if(this.keyword == this.last_keyword) return;
	
	this.last_keyword = this.keyword;
	
	this._timeout = setTimeout(function(){
		_this._triggered = true;
		_this.trigger.call(_this);
	}, 1000);
};

//trigger can be overrided
this.trigger = options.trigger || function(){
	if(typeof(this.url) == 'function'){
		var url = this.url();
	}else{
		var url = this.url;
	}
	
	if(!url.length) return;
	var url = url.replace('###', this.keyword);
	
	if(this.response_type == 'jsonp'){
		$.getJSON(url, this.deploy);
	}else{
		$.ajax({
			url: url,
			type: 'get',
			dataType: 'json',
			data: {keyword: this.keyword},
			success: this.deploy
		});
	}
};

this._callback = function(li){
	//callback return false to prevent default callback
	if(this.callback && this.callback.call(this, li) === false) return;
	
	this.input.val(li.data('value'));
};

/**
json format

**/
this.deploy = function(json){
	this.list.empty();
	this.item_length = json.length;
	this.offset = -1;
	this._current_item = this._last_item = null;
	
	var offset = this.input.offset();
	this.element.css({left: offset.left +'px', top: (offset.top + this.input.height()) +'px'}).
	width(this.input.outerWidth());
	
	this.display(true);
	
	if(!json.length) return;
	
	for(var i = 0; i < this.item_length; i++){
		
		var li = $('<li></li>');
		
		li.html(json[i].text).addClass('item').
		click(function(){
			_this._callback($(this));
		}).
		mouseover(function(){
			_this.move_to($(this).data('offset'));
		}).
		data('value', json[i].value);
		
		
		
		li.data('offset', i);
		
		if(this.item_callback) this.item_callback(li);
		
		this.list.append(li);
		
	}
	
	this._scale = this.list.height() / li.height();
	
};

this.display = function(v){
	if(v){
		//if(this._triggered)
			this.element.show();
	}else{
		setTimeout(function(){_this.element.hide();}, 300);
	}
};
	
}