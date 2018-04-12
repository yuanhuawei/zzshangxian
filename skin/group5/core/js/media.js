var USERNAME = get_username();
$(document).ready(function(){
		//**show_edit**//					   
	init_labelshows('header_t');
	//**menu**//
	$('#topnav li>dl').hide();
	 $("#topnav li:first").addClass('over');
	$("#topnav li").each(function () {
  		$(this).hover(
			function(){
				$('#topnav li').removeClass('over');
				$('#topnav li>dl').hide();
				$(this).addClass('over');
				$(this).find('dl').show().css({
					left: parseInt($(this).position().left) + 'px',
					width:$(this).find('dt').size()*81+'px'
				});
	 		},
			function(){
				$(this).find('dl').hide();
			}
  		)
    });
	
});
