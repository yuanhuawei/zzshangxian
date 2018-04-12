//enabled tab key on textarea
(function($){
$.fn.textarea_tab = function(){
	$(this).keydown(function(e){
		
		if(e.keyCode != 9) return;
		
		if(this.createTextRange){
			//ie
			this.InsertPosition = document.selection.createRange().duplicate();
			this.InsertPosition.text = '\t';
			
			e.returnValue = false;
			
		}else{
			var pos = this.scrollTop;
			var ss = this.selectionStart;
			var es = this.selectionEnd;
			var t = '\t';
			
			this.value = this.value.substring(0, ss) + t + this.value.substring(ss);
			this.focus();
			this.setSelectionRange(ss + t.length, ss + t.length);
			this.scrollTop = pos;
		}
		
		return false;
	});
};
})(jQuery);