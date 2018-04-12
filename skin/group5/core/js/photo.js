var JQPho = 
{
pi : 0, s : 109, u : 0, c : 0, IMGDB : null, MyMar:null, MyMar2 : null, thiss : null,
load : function(){
	thiss = this;
	var hs=document.location.hash;
	var k=hs.split('=');
	var p=k['1'];
	this.pi = p==undefined?0:p-1;
	this.get_data();
	$('#photoloading').show();
	if(!multi_page) $('#showimg').attr({'src':this.IMGDB[this.pi]['url']});
	if(!multi_page) $('#imgtitle').html(this.IMGDB[this.pi]['title']);
	$('#cimg').html(parseInt(this.pi)+1);
	$('#aimg').html(this.u);
	$('#real_link').attr('href',this.IMGDB[this.pi]['url'].replace(/\.cthumb.jpg/gi,''));
	for(var i = 0; i < this.IMGDB.length; i++){ $('#imgs').append("<td id='img_"+i+"'><img src="+this.IMGDB[i]['thumb']+" /></td>");}
		$('#imgs td[id=img_'+this.pi+']').addClass('imgbox');

		$('#imgs td').each(function(){
			$(this).hover( 
				function(){ $(this).addClass('imgbox2');},
				function(){ $(this).removeClass('imgbox2');
			});
			$(this).click(function(){thiss._showimg($(this).attr('id'))});
		});
				
	$('#imgs').width(this.s*this.u);
	this.photoloading();

},
get_data: function(){
	var _IMGDB = [];
	var data = $('#photolist');
	var list = $(data).find('li');
		this.u = list.size();
		this.c=this.u-1;
	$(list).each(function(i){
		var _db = {
			title: $(this).find('h2').html(),
			thumb:$(this).find('img').attr('src'),
			url:$(this).find("i:[title=img]").html(),
			anchor:$(this).find("a").attr('href')
		};
		_IMGDB.push(_db);
	});
	this.IMGDB = _IMGDB;
},
imgshow : function(t){
	$('#box_img').show();
	$('#all_img').hide();
	if(t=='1')this.pi--;
	if(t=='2')this.pi++;
	if(this.pi<0){this.pi=this.c}
	if(this.pi>this.c){this.pi=0;}
	
	this.change_href(this.pi);
	$('#cimg').html(this.pi+1);
	$('#photoloading').show();
	$('#showimg').attr({'src':this.IMGDB[this.pi]['url']});
	if(!multi_page) $('#imgtitle').html(this.IMGDB[this.pi]['title']);
	$('#real_link').attr('href',this.IMGDB[this.pi]['url'].replace(/\.cthumb.jpg/gi,''));
	$('#imgs td').each( function(){ $(this).removeClass('imgbox'); });
	$('#imgs td[id=img_'+this.pi+']').addClass('imgbox');
	$('#divmov')[0].scrollLeft=(this.pi)*this.s;
	this.photoloading();				
},
showall : function(){
	$('#box_img').hide();
	$('#all_img').show().html('');
	for(var i = 0; i < this.u; i++){ $('#all_img').append("<span id='g_"+i+"' class='all_simg'><img src="+this.IMGDB[i]['thumb']+" align='bottom' /></span>");}
	$('#all_img > span').each(function(){ 
		$(this).click(function(){thiss._showimg('im'+$(this).attr('id'))});
	});
},
_showimg : function(d){
	$('#box_img').show();
	$('#all_img').hide();
	$('#imgs td').each( function(){ $(this).removeClass('imgbox'); });
	$('#'+d).addClass('imgbox');
	var k=d.split('_');
	var p=this.pi=k['1'];
	this.change_href(p);
	$('#cimg').html(parseInt(p)+1);
	$('#showimg').attr({'src':this.IMGDB[p]['url']});
	$('#real_link').attr('href',this.IMGDB[p]['url'].replace(/\.cthumb.jpg/gi,''));
},
moveimg : function(k){
	 if(k=='Lo'){clearInterval(this.MyMar);}
	 if(k=='Ro'){clearInterval(this.MyMar2);}
	if(k=='L'){this.MyMar= setInterval(this.Marquee, 1)}
	if(k=='R'){this.MyMar2= setInterval(this.Marquee2, 1)}
				
},
change_href : function(p){
	p=parseInt(p)+1;
	var this_url = document.location.href;
	if(this_url.indexOf('#p')>-1){
		this_url = this_url.replace(/#p=\d+/gi,'#p='+p);
	}else{
		this_url = this_url+'#p='+p;
	}
	document.location.href=this_url;
},
setpoterheight : function(){
	$('#cursor1').css({'height':$('#showimg').height()});
	$('#cursor2').css({'height':$('#showimg').height()});
},
Marquee : function(){
	$('#divmov')[0].scrollLeft-=5;
},
Marquee2 : function(){
		$('#divmov')[0].scrollLeft+=5;
},
photoloading : function(){
	$('#showimg').bind('load',function(){if($('#showimg').attr('src')==thiss.IMGDB[thiss.pi]['url']) $('#photoloading').hide();})
},
init : function(){
	this.load();
}

};
JQPho.init();
