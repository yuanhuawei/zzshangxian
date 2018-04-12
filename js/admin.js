
//menu level 1 css
function core_menu_change_css(){
	$('#submenu').hide();
	$("#core_menu li").each(function (index) {
		$(this).click(function(){
			$('#core_menu li').removeClass('current');
			$('#submenu li:first').addClass('active');
				$("#submenu li").each(function (index) {
					$(this).click(function(){
						$('#submenu li').removeClass();
						$(this).addClass('active');
					});
				});
			$(this).addClass('current');
			$('.menulist').hide();
			$('#submenu').show();
		});
	});
}

//system menu
function append_module_menu(name, id){

	if($('#core_menu #module_menu').length>0)
		$('#core_menu #module_menu').remove();

	$('#core_menu').append('<li id="module_menu" class="current" onclick="get_menu('+ id +')"><span>'+ name +'</span></li>');
	$('#core_menu li').removeClass('current');
	$('#core_menu #module_menu').addClass('current');

	core_menu_change_css();

}

//get menu level 2
function get_menu(id){
	var menu = '';
	var json = get_menu_by_id(id);
	for(var i in json.menus){
		if(MENU_DENIED[json.menus[i].id]) continue;
		
		if(json.menus[i].menus){
			var sub_menus = json.menus[i].menus;
			var co = 0;
			for(var j in sub_menus){
				if(MENU_DENIED[sub_menus[j].id]) co++;
			}
			//检查其子菜单是否被全部禁用,如果被禁用那么父菜单就取消显示
			if(co == count(sub_menus)) continue;
		}
		var url = menu_url(json.menus[i].url);
		menu += '<li id="'+json.menus[i].id+'"><span><a href="'+ (url || 'javascript:void(0);') +'" target="main" onclick="return loadleft(\''+
			url + '\',\''+ json.menus[i].name +'\','+ json.menus[i].parent +','+ json.menus[i].id +');">' + json.menus[i].name + '</a></span></li>';
	}
	$('#submenu').html(menu);
	//submenu_hover();
	
}

function remove_submenu(id){
	$('#submenu #'+id+' dl').remove();
}

//menu level 2 hover
function submenu_hover(){
	$("#submenu li").each(function () {
  		$(this).hover(
			function(){
				if($('#submenu #'+$(this).attr("id")+' dl').length<1){
        			get_submenu($(this).attr("id"));
				}
	 		},
	 		function(){
	   			$('#submenu li dl').remove();
	 		}
  		)
    });
}

//menu level 3
function get_submenu(id){
	var menu = '';
	
	var json = get_menu_by_id(id);
	$('#submenu dl').remove();
	$('#submenu #'+id).append('<dl></dl>');
	for(var i in json.menus){
		if(MENU_DENIED[json.menus[i].id]) continue;
		
		if(typeof(json.menus[i]) != 'object') continue;
		
		var url = menu_url(json.menus[i].url);
		var target = json.menus[i].target || 'main';
		if(!json.menus[i].url){
			target = '';
		}
		
		menu += '<dt>' +
		'<a href="'+ (url || 'javascript:void(0);') +'" target="'+ target +
			'" onclick="return loadleft(\''+
			url + '\',\''+ json.menus[i].name +'\','+ json.menus[i].parent +','+ json.menus[i].id +');">'+
			json.menus[i].name +
		'</a>'+
		'</dt>';
	}
	
	$('#submenu #'+id+' dl').html(menu);
	
	$('#submenu #'+id+' dl ').css({
		left: parseInt($('#submenu #'+ id).position().left) + 'px',
		top: '44px'
	});
	
	
}

//left menu
function show_tree_menu(TreeMenu,obj){
	
    if($('#'+TreeMenu).css('display') == 'none')
	{	$('#tree_inner .menu_icon').slideUp("normal");
		$('#tree_inner .tree_menu h1').removeClass('show_tree_menu');
	    $('#'+TreeMenu).slideDown("normal");
		$(obj).addClass('show_tree_menu');
	}else{
	    $('#'+TreeMenu).slideUp("normal");
		$(obj).removeClass('show_tree_menu');
	}
	onresize();
}

//left menu
function loadleft(current_url, current_name, parent, id){
	
	var menu = '';
	$('#init').hide();
	$('#menu').show();
	
	loadthismenu(id, 3);
	
	var json = get_menu_by_id(parent);
	for(var i in json.menus){
		var tsa = '';
		var url = menu_url(json.menus[i].url);
		if(MENU_DENIED[json.menus[i].id]) continue;
		
		if(id == i) tsa='class="tsa2"';
		
		var target = json.menus[i].target || 'main';
		if(!json.menus[i].url){
			target = '';
		}
		
		menu += '<li>'+
		'<a '+tsa+' href="'+ (url || 'javascript:void(0);') +'" target="'+ target +'" '+
			'onclick="return loadleft(\''+ url+'\',\''+ json.menus[i].name+'\','+ json.menus[i].parent+ ','+ json.menus[i].id+');">'+ json.menus[i].name +'</a>'+
		'</li>';
	}
	
	$('#tree_inner #TreeMenu_MenuList').html(menu);
	return true;
}


//menu level > 3
function loadthismenu(id, layer){
	var menu = '';
	var json = get_menu_by_id(id);
	var url = menu_url(json.url);
	
	if(!json.menus && layer != 3){
		json = get_menu_by_id(json.parent);
	}
	
	if(json.menus){
		var first = true;
		for(var i in json.menus){
			var tsa = '';
			if(MENU_DENIED[json.menus[i].id]) continue;
			
			if(first){
				if(json.url == '' && json.menus[i].url){
					$('#main').attr('src', menu_url(json.menus[i].url));
				}
				first = false;
			}
			
			if(json.menus[i].menus){
				var sub_menus = json.menus[i].menus;
				var co = 0;
				for(var j in sub_menus){
					if(MENU_DENIED[sub_menus[j].id]) co++;
				}
				
				//检查其子菜单是否被全部禁用,如果被禁用那么父菜单就取消显示
				if(co == count(sub_menus)) continue;
			}
			
			if(url == '' || url == '#'){
				url = menu_url(json.menus[i].url);	//父地址不存在或前面的URL不存在就逐个往下
				tsa = 'class="tsa"';
			}else if(json.menus[i].id == id){
				tsa = 'class="tsa"';
			}
			var target = json.menus[i].target || 'main';
			if(!json.menus[i].url){
				target = '';
			}
			
			menu += '<li><a '+tsa+' href="'+ (menu_url(json.menus[i].url) || 'javascript:void(0);') +'" target="'+ target +'" onclick="loadthismenu('+json.menus[i].id+');">'+json.menus[i].name+'</a></li>';
			
		}
	}else{
		menu += '<li><a class="tsa" href="'+ url+ '" target="'+ (json.target || 'main') +'" onclick="loadthismenu('+ id +');">'+json.name+'</a></li>';
	}
	//$('#tree_inner #TreeMenu_Current_Operation').html(menu);
	//if(url!='#' && url!='' )$('#main').attr('src', url);
	
	return true;
}

function menu_url(url){
	return url.length == 0 || url.indexOf('/') == 0 || url.indexOf('http://') == 0 ? url : P8CONFIG.admin_controller +'/'+ url;
}

/*
内容隐藏切换
li和fieldset配对
obj:对象; css:选中后的CSS
例:
<div id="obj"><li>title 1</li><li>title 1</li></div>
<fieldset>content 1</fieldset><fieldset style="display:none;">content 2</fieldset>
$(document).ready(function(){
    show_title_nav('obj','css');
});
*/
function show_title_nav(obj,css,rcss){
	var title_nav_first = $("#" + obj + " li:first") ;
	$("#" + obj + " li").each(function (index) {
	    $(this).click(function(){
		    $(title_nav_first).removeClass();
			$(title_nav_first).addClass(rcss);
			$(this).addClass(css);
			title_nav_first = this; 
			$('fieldset').each(function(f){
				if(f==index){
				    $(this).show();   
				}else{
				    $(this).hide(); 
				} 
			});
		});
    });
}

function detect_template(options){
	var system = options.system || '';
	var module = options.module || '';
	var template = options.template || '';
	var callback = options.callback || null;
	
	$.ajax({
		url: P8CONFIG.admin_controller +'/core-detect_template?system='+ system +'&module='+ module +'&template='+ template,
		cache: false,
		beforeSend: function(){
			ajaxing({});
		},
		success: function(status){
			if(callback){
				callback(status);
			}
		}
	});
}





function Template_Selector(options){

this.dialog = options.dialog;

this.base_dir = options.base_dir || '';
this.selected = options.selected || '';
this.template_dir = options.template_dir;
this.last_ul = null;
this.last_dir = null;
this.last_file = null;
this.value = '';

this.menu_bar = $('<div>\
	<input type="button" value="'+ P8LANG.edit +'" class="edit" />\
	<input type="button" value="'+ P8LANG.refresh +'" class="refresh" />\
	<input type="button" value="'+ P8LANG.copy +'" class="copy" />\
</div>').appendTo(this.dialog.content);
this.content = $('<div></div>').appendTo(this.dialog.content);
this.previewer = $('<div style="position: absolute; z-index: 200001;"><img src="" onerror="this.src=\''+ SKIN +'/nopic.jpg\'" /></div>').hide().appendTo(document.body);

this.inited = false;
this.init_data = [];

var _this = this;

$('.edit', this.menu_bar).click(function(){
	_this.edit();
});

$('.refresh', this.menu_bar).click(function(){
	_this.refresh();
});

$('.copy', this.menu_bar).click(function(){
	_this.copy();
});

this.fetch = function(select, dir){
	
	if(select === null){
		dir = '';
	}
	
	if(this.last_dir == dir) return;
	
	$(select).nextAll('ul').remove();
	
	$.ajax({
		url: P8CONFIG.admin_controller +'/core-template_json?base_dir='+ encodeURIComponent(this.base_dir) +'&dir='+ encodeURIComponent(dir),
		dataType: 'json',
		cache: false,
		async: false,
		beforeSend: function(){
			ajaxing({zIndex: _this.dialog.zIndex +1});
		},
		success: function(json){
			ajaxing({action: 'hide'});
			
			var ul = $('<ul class="template_selector"></ul>');
			
			var init_length = _this.init_data.length;
			var last_dir = _this.init_data.shift();
			
			for(var i = 0; i < json.length; i++){
				var name = basename(json[i].name.replace(/\/$/, ''));
				var li = $('<li title="'+ name +'">'+ name +'</li>');
				ul.append(li);
				
				li.data('data', json[i].name);
				li.data('type', json[i].type);
				li.addClass(json[i].type == 'dir' ? 'dir' : 'html');
				if(!_this.inited && _this.selected == json[i].name){
					li.addClass('selected');
					_this.last_file = json[i].name;
				}
				
				if(json[i].type == 'file'){
					li.mouseover(function(){
						var position = $(this).offset();
						_this.previewer.show().
						css({
							left: $(this).width() + position.left +'px',
							top: position.top +'px'
						}).
						find('img').attr('src', P8_ROOT + _this.template_dir + _this.base_dir + $(this).data('data') +'.jpg');
					}).mouseout(function(){
						_this.previewer.hide();
					});
					
					if(_this.inited && _this.selected == name){
						li.addClass('selected');
					}
				}else{
					if(!_this.inited && last_dir == name){
						li.addClass('selected');
					}
				}
				
				li.click(function(){
					var type = $(this).data('type');
					var data = $(this).data('data');
					
					if(type == 'dir'){
						_this.fetch($(this).parent(), data);
						_this.last_dir = data;
						_this.last_ul = li.parent();
						_this.last_file = null;
					}else{
						_this.value = data;
						$(this).parent().nextAll('ul').find('.selected').removeClass('selected');
						_this.last_file = data;
					}
					
					$(this).parent().find('.selected').removeClass('selected');
					$(this).addClass('selected');
				});
				
				
			}
			
			_this.last_dir = dir;
			
			_this.content.append(ul);
			
			if(init_length){
				_this.last_ul = ul;
				_this.fetch(ul, dir +'/'+ last_dir);
			}else{
				_this.inited = true;
			}
		}
	});
};

this.refresh = function(){
	if(this.last_ul === null){
		this.content.find('ul').remove();
	}
	
	var last_dir = this.last_dir;
	this.last_dir = null;
	this.fetch(this.last_ul, last_dir);
};

this.copy = function(){
	if(this.last_file === null) return;
	
	var new_template = prompt(P8LANG.template_name, basename(this.last_file) +'_copy');
	
	if(new_template){
		$.ajax({
			url: P8CONFIG.admin_controller +'/core-copy_template',
			type: 'post',
			data: {base_dir: this.base_dir, template: this.last_file, new_template: new_template},
			before_send: function(){
				ajaxing({});
			},
			success: function(status){
				ajaxing({action: 'hide'});
				
				_this.refresh();
			}
		});
	}
};

this.edit = function(){
	if(this.last_file === null) return;
	
	window.open(P8CONFIG.admin_controller +'/core-edit_template?base_dir='+ encodeURIComponent(this.base_dir) +'&template='+ encodeURIComponent(this.last_file));
};

this.init = function(){
	
	if(this.inited) return;
	
	this.init_data = this.selected.split('/');
	this.init_data.pop();
	
	this.fetch(null, '');
	
};

}

































function init_tr(context){
	
	$('.hover_table tr', context === undefined ? null : $(context)).
	off('mouseover', init_tr.over).on('mouseover', init_tr.over).
	off('mouseout', init_tr.out).on('mouseout', init_tr.out).
	off('mousedown', init_tr.down).on('mousedown', init_tr.down).
	find('td:first:not(.title) input[type=checkbox]').each(function(){
		
		if(this.checked){
			$(this).parent().parent().addClass('clicked');
		}else{
			$(this).parent().parent().removeClass('clicked');
		}
		
		$(this).off('click', init_tr.check).on('click', init_tr.check);
	}).
	find('td input[type=text]').each(function(){ addClass('txt'); });
}

init_tr.over = function(){
	if($(this).hasClass('title')) return;
	
	$(this).addClass('hover_tr');
}
init_tr.out = function(){
	if($(this).hasClass('title')) return;
	
	$(this).removeClass('hover_tr');
}
init_tr.down = function(){
	if($(this).hasClass('title')) return;
	
	if($(this).parent().hasClass('click_changeable') || $(this).parent().parent().hasClass('click_changeable')){
		
		if(!$(this).hasClass('clicked')){
			$(this).addClass('clicked');
		}else{
			$(this).removeClass('clicked');
		}
	}
	
	$('td:first:not(.title) input[type=checkbox]', this).prop('checked', function(){return !this.checked;}).click();
}
init_tr.check = function(e){
	$(this).prop('checked', !this.checked);//alert(this.checked);
	//return false;
}


function init_help(context){
	//help
	$('.help', context).each(function(i){			 
		$(this).before(
			$('<img src="'+ P8_ROOT +'skin/admin/help_icon.gif" class="helpicon" />').on('click',
                function(){
                    if($(this).parent().find('.help:visible').length){
                        $(this).parent().find('.help').hide();
                    }else{
                        $(this).parent().find('.help').show(); 
                    }
                })
		);
	});
}

$(function(){
	init_tr(null);
	init_help(null);
	
	if($('tr.fix_head').length){
		(function(){
			var fix = $('tr.fix_head');
			var position = fix.position();
			var orig_table = fix.parents('table');
			var table = orig_table.eq(0).clone().empty().appendTo(document.body).hide();
			var copy = fix.clone(true);
			copy.appendTo(table.css({position: 'fixed', left: 0, top: 0}));
			
			$(window).scroll(function(){
				var top = get_scrollTop();
				if(top > position.top){
					 table.show();
				}else{
					table.hide();
				}
				
				//table.css({'left':15-document.documentElement.scrollLeft});
			});
		})();
	}
});