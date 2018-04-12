//科室导航
function myNav(){
	if($("#nav").hasClass("openNav")){
		$("#nav-over").css("display","none");
		$("#nav").removeClass("openNav");
		$("#warmp,.footer-con").removeClass("openMenu");
	}else{
		$("#nav-over").css("display","block");
		$("#nav").addClass("openNav");
		$("#warmp,.footer-con").addClass("openMenu");
				
		$("#scrollerBox").height($(window).height() - $("#nav h3").outerHeight());
		//new IScroll('#scrollerBox',{preventDefault:false});		
		$(window).resize(function(){
			$("#scrollerBox").height($(window).height() - $("#nav h3").outerHeight());
		})
	}	
}
//项目导航
function ksNav(){
	if($("#ks-nav").hasClass("openNav")){
		$("#nav-over").css("display","none");
		$("#ks-nav").removeClass("openNav");
		$("#warmp,.footer-con").removeClass("openMenu")	
	}else{
		$("#nav-over").css("display","block");
		$("#ks-nav").addClass("openNav");
		$("#warmp,.footer-con").addClass("openMenu");
		
		
		$("#ks-scrollerBox").height($(window).height() - $("#ks-nav h3").outerHeight());
		//new IScroll('#ks-scrollerBox',{preventDefault:false});		
		$(window).resize(function(){
			$("#ks-scrollerBox").height($(window).height() - $("#nav h3").outerHeight());
		})
	}
}
$("#nav-over").bind("click",function(){
	$("#nav-over").css("display","none");
	$("#warmp,.footer-con").removeClass("openMenu");
	$("#nav").removeClass("openNav");
	$("#ks-nav").removeClass("openNav");
	$("#warmp,.footer-con").removeClass("openMenu")	
})
$("#nav-over").bind("touchmove touch",function(e){e.preventDefault()},false);//阴止默认事件
$(".navHome").bind("click",myNav);
$(".navIteam").bind("click",ksNav);

//焦点图
TouchSlide({ 
	slideCell:"#slides",
	titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
	mainCell:".bd ul", 
	effect:"leftLoop", 
	autoPage:true,//自动分页
	autoPlay:true //自动播放
});
//项目二
TouchSlide({ 
	slideCell:"#tab-iteam2",
	titCell:".tab-iteam-hd li",
	mainCell:".tab-iteam-con",
	startFun:function(i,c){	
	},
	endFun:function(i,c){	
		/*$("#tab-iteam2 .tempWrap").height($("#tab-iteam2 .con").eq(i).children("ul").height()+$("#tab-iteam2 .con").children("a").outerHeight()+40);	*/
		var bd = document.getElementById("tabBox2-bd");
		bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+bd.children[i].children[1].offsetHeight+20+"px";
		if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
		
		var widths = 0;
		for(j=0;j<i-1;j++){
			widths += $("#tab-iteam2 .tab-iteam-hd ul li").eq(j).outerWidth();							
		}
		if(i+1!=c){
			$("#tab-iteam2 .tab-iteam-hd ul").animate({"left":-widths},400)	
		}
	}
});

//荣誉
$("#tab-honner .tab-honner-hd ul li").each(function(i) {
    $(this).click(function(){	
		$(this).addClass("on").siblings().removeClass("on");	
		$("#tab-honner .tab-honner-con .con").eq(i).show().siblings().hide();
		TouchSlide({ 
			slideCell: "#"+$("#tab-honner .tab-honner-con .con").eq(i).children("div").attr("id"),
			mainCell:".bd ul", 
			effect:"leftLoop", 
			autoPlay:true,//自动播放
			interTime:5000,
			autoPage:false, //自动分页
			prevCell:".prev",
			nextCell:".next",
			switchLoad:"_src" //切换加载，真实图片路径为"_src" 
		});
	})
});
TouchSlide({ 
	slideCell:"#zizhi",
	mainCell:".bd ul", 
	effect:"leftLoop", 
	autoPlay:true,//自动播放
	interTime:5000,
	autoPage:false, //自动分页
	prevCell:".prev",
	nextCell:".next",
	switchLoad:"_src" //切换加载，真实图片路径为"_src" 
});

//案例
TouchSlide({ 
	slideCell:"#case",
	mainCell:".bd ul", 
	effect:"leftLoop", 
	autoPlay:true,//自动播放
	interTime:5000,
	autoPage:false, //自动分页
	prevCell:".prev",
	nextCell:".next",
	switchLoad:"_src" //切换加载，真实图片路径为"_src" 
});
//专家
TouchSlide({ 
	slideCell:"#team",
	mainCell:".bd ul", 
	effect:"leftLoop", 
	autoPlay:true,//自动播放
	interTime:5000,
	autoPage:false, //自动分页
	prevCell:".prev",
	nextCell:".next",
	switchLoad:"_src" //切换加载，真实图片路径为"_src" 
});

//返回顶部
$("#backtop").click(function(){$("html,body").animate({scrollTop:0},300)})
//$("body").append('<div class="gotop" id="gotop"><img src="_m/imges/top.png"><div>');
//$(window).scroll(function(){$(document).scrollTop()>300?$("#gotop").fadeIn():$("#gotop").fadeOut()});
//$("#gotop").click(function(){$("html,body").animate({scrollTop:0},300)})
//标题文字滚动
//function run(obj){
//	var obj = document.getElementById(obj);
//	var strText= obj.innerHTML;
//	strText=strText.substring(1,strText.length)	+ strText.substring(0,1);
//	obj.innerHTML = strText;	  
//}
//setInterval('run("title")',400);

var min_size = 12,max_size = 24,cur_size=0;

function smallFont()
{
	try{
		if(cur_size==0)
			cur_size = parseInt($('.fontsizebox').css('font-size').replace('px',''));
		if((cur_size-1)<12)
		{
			SetCookie("site_font_size", cur_size);
			return;
		}
		cur_size = cur_size-1;
		$('.fontsizebox').css('font-size', cur_size);
		SetCookie("site_font_size", cur_size);
	}catch(e){
	}
};

function largeFont()
{
	try{
		if(cur_size==0)
			cur_size = parseInt($('.fontsizebox').css('font-size').replace('px',''));
		if((cur_size+1)>24)
		{
			SetCookie("site_font_size", cur_size);
			return;
		}
		cur_size = cur_size+1;
		$('.fontsizebox').css('font-size', cur_size);
		SetCookie("site_font_size", cur_size);
	}catch(e){
	}
};

/**
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

*/

function getSiteFontSize()
{
	try{
		var site_font_size = parseInt(GetCookie("site_font_size"));
		$('.fontsizebox').css('font-size', site_font_size);
	}catch(e){
	}
}

function GetCookie(sName)
{
    var aCookie = document.cookie.split("; ");

    for(var i = 0; i < aCookie.length; i++)
    {
        var aCrumb = aCookie[i].split("=");
        if(sName == aCrumb[0])
            return unescape(aCrumb[1]);
    }

    return null;
}

function SetCookie(sName, sValue)
{
    var nowdate = new Date();
    nowdate.setYear(nowdate.getYear() + 1);
    document.cookie = sName + "=" + escape(sValue) + "; expires=" + nowdate.toUTCString() + ";";
}





