var USERNAME = get_username();
$(document).ready(function(){
		//**show_edit**//					   
	init_labelshows('header_t');
	//**menu**//
	$(document).ready(function(){
	
	$('#menu_nav li>dl').hide();
	 $("#menu_nav li:first").addClass('over');
	$("#menu_nav li").each(function () {
  		$(this).hover(
			function(){
				$('#menu_nav li').removeClass();
				$('#menu_nav li>dl').hide();
				$(this).addClass('over');
				$(this).find('dl').show();
				$(this).find('dl').css({left: parseInt($(this).position().left) + 'px',position:'absolute'});
	 		},
			function(){
				$(this).find('dl').hide();
				}
  		)
    });
});
	//**login box**//
	if(USERNAME !==undefined){
		$('#username').html(USERNAME);
		$('#login_info').show();
	}else{
		$('#forward').val(window.location.href);
		$('#login_link').show();
	}
	
});