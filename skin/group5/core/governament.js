var USERNAME = get_username();
$(document).ready(function(){
	//**show_edit**//					   
	init_labelshows('header_t');
	//**menu**//
	$('#menu_nav li>dl').hide();
	 $("#menu_nav li:first").addClass('over');
	$("#menu_nav li").each(function () {
  		$(this).hover(
			function(){
				$('#menu_nav li').removeClass('over');
				$('#menu_nav li>dl').hide();
				$(this).addClass('over');
				$(this).find('dl').show().css({
					left: parseInt($(this).position().left) + 'px',
				});
	 		},
			function(){
				$(this).find('dl').hide();
				}
  		)
    });
})
