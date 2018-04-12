// JavaScript Document
var loading = 'loading......';


function ShowTopMenu(id)
{
	var menu = '';
	
	var json = get_menu_by_id(id);
	var j = 0;
	for(var i in json.menus){
		if(MENU_DENIED[i]) continue;
		
		menu += '<li id="'+json.menus[i].id+'">' + json.menus[i].name + '</li>';
		if(j==0){
			ShowMenu(json.menus[i].id);
		}
		j++;
	}
	$('#Modules').html(menu);
	$('#Modules li:first').addClass('menu_focus');
	MenuClick();
}

function ShowMenu(id)
{
	var menu = target = '';
	if(!id) return '';
	
	var json = get_menu_by_id(id);
	for(var i in json.menus){
		if(MENU_DENIED[i]) continue;
		
		if(json.menus[i].target == ''){
			target='wrapright';
		}else{
			target=json.menus[i].target;
		}
		menu += '<li><a href="'+json.menus[i].url+'" target="'+target+'">' + json.menus[i].name + '</a></li>';
	}
	$('#menu_panel_conten').html(menu);
}

function MenuClick()
{
	$('#Modules li').each(function(){
		$(this).click(function(){
			$('#Modules li').removeClass('menu_focus');
			$(this).addClass('menu_focus');
			ShowMenu($(this).attr("id"));
		});
	});
}

function ChangeTabs(ID,Num)
{
	for (i=1;i<= Num;i++){
		if(i == ID){
			$("#TabMenu" + i).addClass("tabs_focus");
            $("#Tabs" + i).show();
        }else{
            $("#TabMenu" + i).removeClass();
            $("#Tabs" + i).hide();
        }
   }
}

function MoveTabs(id,sid){
	if(!sid)sid=0;
	$("#"+id+" .head span").eq(sid).addClass("over");
	$("#"+id+" .main .content").eq(sid).siblings("#"+id+" .main .content").hide().end().show();
	$("#"+id+" .head span").off("click").on("click", function(){
		$(this).siblings("span").removeClass("over").end().addClass("over");
		var index = $("#"+id+" .head span").index( $(this) );
		$("#"+id+" .main .content").eq(index).siblings("#"+id+" .main .content").hide().end().fadeIn("fast");
   });
}

function ShowSecMenu(id,obj){
	var menu = target = '';
	
	if(!id) return '';
	
	var json = get_menu_by_id(id);
	for(var i in json.menus){
		if(MENU_DENIED[i]) continue;
		
		menu += '<div class="left_menu">\
			<div class="lm_title lm'+json.menus[i].id+'">'
			+ json.menus[i].name +
			'</div>\
			<div class="lm_main">\
				<ul class="lm_sty1">';
		
		var _json=get_menu_by_id(json.menus[i].id);
		for(var j in _json.menus){
			if(MENU_DENIED[j]) continue;
			
			if(_json.menus[j].target == ''){
				target = 'wrapright';
			}else{
				target = _json.menus[j].target;
			}
			menu += '<li><a href="'+_json.menus[j].url+'" target="'+target+'" class="lm'+_json.menus[j].id+'">' + _json.menus[j].name + '</a></li>';
		}
		
		menu += '</ul>\
			</div>\
		</div>';
	}
	$('#menu2').html(menu);
	main_url = $(obj).attr('href');
	if(main_url)$('#wrapright').attr('src',main_url);
	
}



function member_labelshows(id){
		if(get_cookie('IS_ADMIN') !==undefined){
		if(LABEL_URL.indexOf('edit_label')==-1){
			var ls='?';
			if(LABEL_URL.indexOf('?')>-1)ls='&';
			LABEL_URL=LABEL_URL+ls+'edit_label=1';
			$('#'+id).append('<a href='+LABEL_URL+' id="edit_label">['+ P8LANG.showlabel +']</a>');
		}else{
			LABEL_URL=LABEL_URL.replace('&edit_label=1','');
			LABEL_URL=LABEL_URL.replace('edit_label=1','');
			$('#edit_label').remove();
			$('#'+id).append('<a href='+LABEL_URL+' >['+ P8LANG.hidelabel +']</a>');
		}
		
	}
	
}

var __last_auto_height = 0;
function _auto_height(){
	
	var height = $(document.body).height();
	if(height > 400 && height > __last_auto_height){
		$('#_auto_height').attr('src', P8CONFIG.url +'/api/member_panel_proxy.html?_='+ Math.random() +'#'+ height);
	}
	
	__last_auto_height = height;
}

$(function(){
	
		
	if(self == parent) return;
	
	setInterval(_auto_height, 1000);
});
