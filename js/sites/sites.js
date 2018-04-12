function get_matrix_user(){
	$.getJSON(P8CONFIG.controller+'/member-user_jsonp?callback=?',function(msg){
		if(msg){
			for(i in msg){
				name = P8CONFIG.cookie_prefix + i;
				$_COOKIE[name] = msg[i];
			
			}
		}
	});
}
if(get_cookie('USERNAME')==undefined)
	get_matrix_user();