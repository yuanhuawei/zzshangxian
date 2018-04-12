var USERNAME = get_username();
function getMessage(){
	setTimeout(getMessage,30000);//时间可控                        
	$.ajax({  
		url: P8CONFIG.U_controller+'/core/member-message_box',                    
		type: 'POST',
		dataType: 'json', 
		data: ajax_parameters({type:'in'}),
		cache: false,
		success: function(json){    
			showMessage(json);     
		}
	});
}

function showMessage(json){
	if(json['no_read']>0){
		$("#message_count").text(json['no_read']); 
		$("#message_from").text(json['from']);
		$("#message_title").text(json['title']);
		$("#message_content").html(json['content']);
		$("#message_inbox_url").attr("href",json['inbox_url']);     
		$("#message_read_url").attr("href",json['read_url']);
		$("#message_find_url").attr("href",json['read_url']); 
		$("#message_refuse").click(function(){refuse(json['id'])});
		openMessage();   
	}else{
		closeMessage();  
	} 
}  

function closeMessage(){
	$("#message_box").slideUp("slow");
}

function openMessage(){
	$("#message_box").slideDown("slow");
}
function showmessagebox(){
	messageBox=$('<link rel="stylesheet" type="text/css" href="'+P8CONFIG.RESOURCE+'/images/message/style.css" />\
<div id="message_box">\
	<div class="msg_head">\
		<a href="javascript:void(0)" class="msg_close" onclick="closeMessage();">&nbsp;</a>\
		<a href="javascript:void(0)" class="msg_new" id="message_inbox_url" target="wrapright" onclick="closeMessage();">未读消息<font id="message_count"></font>条</a>\
	</div>\
	<div class="msg_main">\
		<div>\
			<span class="user_name">'+USERNAME+'</span>\
			<span class="form">From:<font id="message_from"></font></span>\
		</div>\
		<div class="msg_title">标题：<font id="message_title"></font></div>\
		<div class="msg_content">内容：<font id="message_content"></font></div>\
		<div class="msg_button">\
			<a href="javascript:void(0)" target="wrapright" id="message_read_url" onclick="closeMessage();">阅读</a>\
			<a href="javascript:void(0)" id="message_refuse" onclick="closeMessage();">拒绝</a></span>\
			<a id="message_find_url" href="" target="wrapright" onclick="closeMessage();">查看</a>\
		</div>\
	</div>\
</div>\
');
	$(document.body).append(messageBox);
	$(window).scroll( function() {
		messageBox.css("bottom","1px");
		messageBox.css("bottom","0px");
	});

}
function refuse(id){
	$.ajax({  
		url: P8CONFIG.U_controller+'/core/member-message_box',                    
		type: 'POST',
		dataType: 'json', 
		data: ajax_parameters({type: 'rubbish', id: id}),
		cache: false,
		success: function(json){
			if(id=json['id']&&json['move']=='true'){
				closeMessage();  
			}
		}
	});
}

$(document).ready(function(){
	
	if(USERNAME !==undefined){ 
	showmessagebox();
	getMessage();
	}
	
});