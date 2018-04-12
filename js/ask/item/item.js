function item_operation(ele){
	var menu = $('\
	<ul style="position: absolute; border: 2px solid #09C; background-color: #ffffff; padding: 5px;">\
		<li><a router="/'+ SYSTEM +'/item-edit?id='+ item_id +'" target="_blank">'+ P8LANG.edit +'</a></li>\
		<li><a router="/'+ SYSTEM +'/item-list?search_type=id&keyword='+ item_id +'&check=1" target="_blank">'+ P8LANG.recommend +'</a></li>\
		<li><a router="/'+ SYSTEM +'/item-list?search_type=id&keyword='+ item_id +'&check=1" target="_blank">'+ P8LANG.more +'</a></li>\
	</ul>\
	');
	
	$(ele).click(function(){
		var offset = $(this).offset();
		menu.toggle().css({
			left: offset.left +'px',
			top: ($(this).height() + offset.top) +'px'
		});
		
		if(!$(ele).data('shown')){
			get_admin_controller(function(c){
				menu.find('li a').each(function(){
					this.href = c + $(this).attr('router');
				});
			});
		}else{
			$(ele).data('shown', 1);
		}
	});
	
	$(document.body).append(menu);
	menu.hide();
}