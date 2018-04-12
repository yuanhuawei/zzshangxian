var P8_Marquee;
(function($){

P8_Marquee = function(options){

this.options = {
	container: $(options.container),
	content: $(options.content),
	direction: options.direction || 'up',
	play_timeout: options.play_timeout || 1,
	stop_timeout: options.stop_timeout || 0,
	scroll: options.scroll || 0
};

this.container = $(this.options.container);
this.content = $(this.options.content);
this.direction = this.options.direction;

var c_width = this.container.width(),
	c_height = this.container.height(),
	width = this.content.width(),
	height = this.content.height();
switch(this.direction){
case 'up': case 'down': if(height < c_height) return;
case 'left': case 'right': if(width < c_width) return;
}

this._content = this.content.clone(true).attr('id', '').insertAfter(this.content);
this.interval = null;
this.counter = 0;
this.offset = 0;
this.playing = false;
this._timeout = null;

var _this = this;

this.container.mouseover(function(){
	_this.stop();
});

this.container.mouseout(function(){
	_this.play();
});


this.stop = function(){
	clearInterval(this.interval);
	if(this._timeout) clearTimeout(this._timeout);
};

this.play = function(){
	if(this.interval) clearInterval(this.interval);
	this.interval = setInterval(function(){ _this._play(); }, this.options.play_timeout);
};

this._play = function(){
	if(this.options.scroll && this.options.stop_timeout){
		if(this.counter == this.options.scroll){
			this.counter = 0;
			
			this.stop();
			this._timeout = setTimeout(function(){ _this.play(); }, this.options.stop_timeout);
			return;
		}
		
		this.counter++;
	}
	
	var e = this.container.get(0);
	
	switch(this.direction){
		case 'up':
			if(e.scrollTop >= this.content.height())
				e.scrollTop = 1;
			else
				e.scrollTop++;
		break;
		
		case 'down':
			if(e.scrollTop == 0)
				e.scrollTop = this.content.height() +1;
			else
				e.scrollTop--;
		break;
		
		case 'left':
			if(e.scrollLeft >= this.content.width())
				e.scrollLeft = 1;
			else
				e.scrollLeft++;
		break;
		
		case 'right':
			if(e.scrollLeft == 0)
				e.scrollLeft = this.content.width() +1;
			else
				e.scrollLeft--;
		break;
	}
};

this.container.get(0).scrollTop = this.direction == 'up' ? 0 : this.content.height();
this.container.get(0).scrollLeft = this.direction == 'left' ? 0 : this.content.width();

this.play();

};

})(jQuery);