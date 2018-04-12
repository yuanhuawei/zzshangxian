/**
html structure
<ul class="category_container" data="$selected_category_id">
	<li data="$category_id" class="selected multi_selected">
		<checkbox onclick="collect multi_values">
		<span onclick="this.get_sub">$category_name</span>
	</li>
</ul>
**/
function Recursive_Selector(options){

this.json = options.json ? clone(options.json) : null;
this.path = options.path ? clone(options.path) : null;
this.input = options.input;
this.dialog = options.dialog;

this.parents = options.parents || null;
this.url = options.url || null;
this.filter = options.filter || null;
this.item_callback = options.item_callback || null;
this.change = options.change || null;
this.init_callback = options.init_callback || null;
this.multiple = options.multiple || false;
this.value = options.value === undefined ? null : options.value;	//categories, menus
this.values = options.values === undefined ? '' : options.values;	//categories, menus
this.sub_property = options.sub_property || '';
this.className = options.className || 'category_container';

if(this.url && !Recursive_Selector.list_cache[this.url]) Recursive_Selector.list_cache[this.url] = {};
if(this.url && !Recursive_Selector.item_cache[this.url]) Recursive_Selector.item_cache[this.url] = {};

this._values = {};
this._value = this.value;
this._last_parent = -1;

var tmp = this.values.replace(/[^0-9,]/g, '').split(',');
for(var i = 0; i < tmp.length; i++){
	this._values[tmp[i]] = 1;
}

var _this = this;

this.get_value = function(){
	if(this.multiple){
		var ret = [];
		for(var i in this._values){
			ret.push(i);
		}
		return ret;
	}else{
		return this._value;
	}
};

this.get_by_id = function(id, callback){
	
	if(this.url){
		if(Recursive_Selector.item_cache[this.url][id] !== undefined){
			if(callback) callback.call(this, Recursive_Selector.item_cache[this.url][id]);
			
			return Recursive_Selector.item_cache[this.url][id];
		}
		
		ajaxing({});
		
		if(typeof(id) == 'object'){
			for(var i in id) Recursive_Selector.item_cache[this.url][id[i]] = null;
		}else{
			Recursive_Selector.item_cache[this.url][id] = null;
		}
		
		$.getJSON(this.url+(this.url.indexOf('?')>-1?'&':'?') +'callback=?'+ ajax_parameters({id: id}), function(json){
			ajaxing({action: 'hide'});
			
			for(var i in json){
				Recursive_Selector.item_cache[_this.url][i] = json[i];
				
				for(var j in json[i].paths){
					var path = json[i].paths[j];
					Recursive_Selector.list_cache[_this.url][j] = path;
					
					for(var k in path){
						Recursive_Selector.item_cache[_this.url][k] = path[k];
					}
				}
				
				if(callback) callback.call(_this, json[i]);
			}
			
			//alert(print_r(Recursive_Selector.item_cache));
		});
		
		return;
	}
	
	if(this.path[id] === undefined) return {};
	
	var path = clone(this.path[id]);
	var root = path.shift();
	var search = this.find_by_id(root,this.json);
	if(path.length == 0){
		return search;
	}
	for(var i in path){
		search = this.find_by_id(path[i],search[this.sub_property]);
		//search = search[this.sub_property][path[i]];
	}
	return search;
};

this.find_by_id = function(id,json){
	for(var i in json){
		if(json[i].id==id)	
			return json[i];
	}
	return {};
};

this.get = function(select, selected, callback){
	if(select == null){
		//first
		var parent = 0;
	}else{
		var parent = $(select).data('value') || 0;
		
		if(!this.multiple){
			this._value = parent;
			$(this.input).val(parent);
		}
		
		if(parent == this._last_parent) return;
		
		this._last_parent = parent;
		
		if(parent == 0){
			if(!this.multiple)
				$(this.input).val($(select).parent().prev('ul').data('value'));
			
			$(select).nextAll('ul').remove();
			return;
		}
		$(select).nextAll('ul').remove();
		
		if(!select.find('li.selected').data('sub')){
			return;
		}
		
	}
	
	if(this.url){
		var children;
		
		if(Recursive_Selector.list_cache[this.url][parent]){
			children = Recursive_Selector.list_cache[this.url][parent];
			
		}else{
			
			ajaxing({});
			
			$.getJSON(this.url+ (this.url.indexOf('?')>-1?'&':'?') +'parent='+ parent +'&callback=?', function(json){
				ajaxing({action: 'hide'});
				
				Recursive_Selector.list_cache[_this.url][parent] = json;
				for(var i in json){
					Recursive_Selector.item_cache[_this.url][json[i].id] = json[i];
				}
				
				_this._last_parent = -1;
				_this.get(select, selected, callback);
			});
			
			return;
		}
		
	}else{
		var children = parent ? this.get_by_id(parent)[this.sub_property] : this.json;
	}
	
	var ul = $('<ul class="'+ this.className +'"></ul>');
	if(select == null){
		var li = $('<li>'+ P8LANG['null'] +'</li>').click(function(){
			_this.input.val(0);
			_this._value = 0;
			$(this).parent().parent().find('.selected').removeClass('selected');
		});
		ul.append(li);
	}
	ul.data('value', selected);
	
	for(var i in children){
		if(this.filter){
			if(!this.filter.call(this, children[i])) continue;
		}
		
		if(children[i][this.sub_property]){
			var li = $('<li> <span title="'+ children[i].id +':'+ children[i].name +'">'+ children[i].name +'</span></li>').data('sub', true);
		}else{
			var li = $('<li> <span title="'+ children[i].id +':'+ children[i].name +'">'+ children[i].name +'</span></li>');
		}
		
		//multiple{
		if(this.multiple){
			var checkbox = $('<input type="checkbox" value="'+ children[i].id +'" />');
			
			checkbox.click(function(){
				if(this.checked){
					$(this).parent().addClass('multi_selected');
					_this._values[this.value] = 1;
				}else{
					$(this).parent().removeClass('multi_selected');
					delete _this._values[this.value];
				}
				
			});
			
			li.prepend(checkbox);
			if(this._values[children[i].id]){
				checkbox.prop('checked', true);
				li.addClass('multi_selected');
				this._values[children[i].id] = 1;
			}
		}
		//multiple}
		
		li.data('value', children[i].id);
		li.find('span').click(function(){
			$(this).parent().parent().data('value', $(this).parent().data('value'));
			
			$(this).parent().parent().find('.selected').removeClass('selected');
			
			var flag = true;
			
			if(_this.change){
				if(_this.change.call(_this, $(this).parent().parent()) === false){
					flag = false;
				}
			}
			
			if(flag){
				_this.get($(this).parent().addClass('selected').parent());
			}
		});
		
		if(children[i].id == selected){
			li.addClass('selected');
		}
		
		if(this.item_callback){
			this.item_callback.call(this, children[i], li);
		}
		
		ul.append(li);
	}
	
	$(ul).parent().nextAll('ul').remove();
	
	this.dialog.content.append(ul);
	
	if(callback) callback.call(this);
};

this.inited = false;

this.init = function(reinit){
	if(this.inited && reinit !== true) return;
	
	this.inited = true;
	this.dialog.content.empty();
	
	var value = this.get_value();
	
	if(this.url && value && value != '' && ( typeof(value) == 'object' || !isNaN(value) && value != 0 )){
		
		if(typeof(value) != 'object') value = [value];
		
		this.get_by_id(value, function(json){
			
			for(var i in json.parents){
				var ul = $('ul:last', this.dialog.content);
				ul = ul.length ? ul : null;
				
				if(!_this.multiple || ul == null) this.get(ul, json.parents[i].id);
			}
			
			if(!_this.multiple) this.get($('ul:last', this.dialog.content), json.id);
			
			if(this.init_callback) this.init_callback.call(this);
		});
		
		return;
	}
	
	if(this.parents){
		var first = this.parents.shift();
		this.get(null, first);
		
		for(i = 0; i < this.parents.length; i++){
			this.get($('ul:last', this.dialog.content), this.parents[i]);
		}
		
		this.get($('ul:last', this.dialog.content));
	}else{
		this.get(null);
	}
	
	if(this.init_callback) this.init_callback.call(this);
};

}

Recursive_Selector.item_cache = {};
Recursive_Selector.list_cache = {};