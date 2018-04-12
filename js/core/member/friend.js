function P8_Friend(){

this.dialog = new P8_Dialog({
	width: 300,
	height: 140,
	title_text: P8LANG.core.member.friend.add,
	overlay: false,
	button: true,
	ok: function(){
		
		if(_this._friend_ajaxed[_this.fuid]) return;
		
		_this._friend_ajaxed[_this.fuid] = 1;
		
		var cid = this.content.find('select').val();
		var description = this.content.find('input').val();
		
		$.ajax({
			url: P8CONFIG.URI['core']['member'].U_controller +'-add_friend',
			data: {
				fuid: _this.fuid,
				cid: cid,
				description: description,
				_ajax_request: 1
			},
			success: function(status){
				
				status = parseInt(status);
				
				_this.dialog.close();
				
				switch(status){
					case 1:
						alert(P8LANG.core.member.friend.status['-1']);
					break;
					
					case -4:
						alert(P8LANG.core.member.friend.status['-4']);
					break;
				}
				
				
			}
		});
		
		return false;
	}
});

this.categories = [];
this._category_ajaxed = false;
this._friend_ajaxed = {};
this._ajax_messages = {};
this.fuid = 0;
this.status;
this.add_content = $('<div><select><option value="0">'+ P8LANG.select_category +'</option></select></div>\
<div class="description">'+ P8LANG.core.member.friend.description +':<input type="text" /></div>');

var _this = this;

this.add = function(fuid){
	if(fuid == get_cookie('UID')) return;
	
	if(this._friend_ajaxed[fuid]) return;
	
	this.fuid = fuid;
	this.get_category(function(){
		
		for(var id in json){
			_this.add_content.find('select').append('<option value="'+ id +'">'+ json[id].name +'</option>');
		}
		
	});
	this.dialog.show();
	this.dialog.content.append(this.add_content);
	
	$.ajax({
		url: P8CONFIG.U_controller +'/member-add_friend',
		data: {
			fuid: _this.fuid,
			test: 1
		},
		success: function(status){
			status = parseInt(status);
			_this.status = status;
			
			_this._ajax_messages[_this.fuid] = P8LANG.core.member.friend.status[status];
			
			if(status == -3){
				_this.dialog.content.find('.description').html(P8LANG.core.member.friend.verify_message +': <input type="text" />');
			}else if(status == 1){
				
			}else{
				_this.dialog.content.empty().html(_this._ajax_messages[_this.fuid]);
				_this._friend_ajaxed[_this.fuid] = 1;
			}
		}
	});
	return;
	
};

this.get = function(func){
	$.getJSON(P8CONFIG.URI['core']['member'].U_controller +'-friend?_ajax_request=1&callback=?', func);
};

this.get_category = function(func){
	if(this._category_ajaxed) return;
	
	$.getJSON(P8CONFIG.URI['core']['member'].U_controller +'-friend_category?_ajax_request=1&callback=?', function(json){
		this.categories = json;
		_this._category_ajaxed = true;
		
	});
	
};

}