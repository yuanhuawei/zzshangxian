<?php
defined('PHP168_PATH') or die();
?>
<?php
$swidth = strpos($swidth, '%')!==false?$swidth:$swidth.'px';
print <<<EOT

<style type="text/css">
#slide{$label['id']}{width:{$swidth};height:{$sheight}px;position: relative; height: {$sheight}px; overflow: hidden; background: url({$RESOURCE}/skin/label/slide15/loading.gif) 50% no-repeat;}
#slide{$label['id']} img{width:{$swidth};height:{$sheight}px;}
#slide{$label['id']} li { list-style-type: none; }
#slide{$label['id']} .slides { position: relative; z-index: 1; }
#slide{$label['id']} .slides li { width:{$swidth}; height: {$sheight}px; position:absolute;	top:0px;	left:0px;	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";	-moz-opacity:0;	filter:alpha(opacity=0);	opacity:0}
#slide{$label['id']} .flex-control-nav { position: absolute; bottom: 35px; z-index: 2; width: 100%; text-align: center; }
#slide{$label['id']} .flex-control-nav li { display: inline-block; width: 14px; height: 14px; margin: 0 5px; *display:inline;zoom: 1; }
#slide{$label['id']} .flex-control-nav a { display: inline-block; width: 14px; height: 14px; line-height: 40px; overflow: hidden; background: url({$RESOURCE}/skin/label/slide15/dot.png) right 0 no-repeat; cursor: pointer; }
#slide{$label['id']} .flex-control-nav .active { background-position: 2px 0; }
#slide{$label['id']} .flex-direction-nav { position: absolute; z-index: 3; width: 100%; top: 45%; }
#slide{$label['id']} .flex-direction-nav li a { display: block; width: 50px; height: 50px; overflow: hidden; cursor: pointer; position: absolute; }
#slide{$label['id']} .flex-direction-nav li a.prev { left: 40px; background: url({$RESOURCE}/skin/label/slide15/prev.png) center center no-repeat; }
#slide{$label['id']} .flex-direction-nav li a.next { right: 40px; background: url({$RESOURCE}/skin/label/slide15/next.png) center center no-repeat; }
</style>
<div id="slide{$label['id']}" class="flexslider">
<ul class="slides">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li><a href="$value[url]" target="_blank" title="$value[full_title]"><img src="$value[frame]" alt="$value[full_title]"/></a></li>
EOT;
}
}

print <<<EOT

</ul>
<ol class="flex-control-nav">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $k => $value){
print <<<EOT

<li><a class="">$k</a></li>
EOT;
}
}

print <<<EOT

</ol>
<ul class="flex-direction-nav">
<li><a class="prev" alt="prev" href="#"></a>
<li><a class="next" alt="next" href="#"></a>
</ul>
</div>
<script type="text/javascript">
(function () {
var num = $("#slide{$label['id']} .slides li").length,	now = 0;	$('#slide{$label['id']} .slides li:first').css({"z-index":"2","opacity":"1"});	$("#slide{$label['id']} .flex-control-nav li:first a").addClass("active");
function next() {	now = (++now) % num;	return now;	}
function callback() {		$("#slide{$label['id']} .flex-control-nav li").find('a').removeClass('active');		$("#slide{$label['id']} .slides").find('li').css('z-index', '1');		$("#slide{$label['id']} .flex-control-nav").find('li:eq(' + now + ')').find('a').addClass('active');$("#slide{$label['id']} .slides").find('li:eq(' + now + ')').css('z-index', '2');};
function animagea() {		$("#slide{$label['id']} .slides").find('li:eq(' + now + ')').animate({opacity : 0}, 1500);		$("#slide{$label['id']} .slides").find('li:eq(' + next() + ')').animate({	opacity : 1	}, 1500, callback);}
var timer =  setInterval(animagea, 5000);
$("#slide{$label['id']} .flex-direction-nav li").find('a').click(function(){ clearInterval(timer);		if($(this).attr('alt')=='prev'){			$("#slide{$label['id']} .slides").find('li:eq(' + now + ')').animate({opacity : 0}, 500);			now = now-2;			if(now<0){				now = num+now;			}			$("#slide{$label['id']} .slides").find('li:eq(' + next() + ')').animate({	opacity : 1	}, 500, callback);}else{			$("#slide{$label['id']} .slides").find('li:eq(' + now + ')').animate({opacity : 0}, 100);			$("#slide{$label['id']} .slides").find('li:eq(' + next() + ')').animate({	opacity : 1	}, 500, callback);} timer =  setInterval(animagea, 5000);});
})()
</script>
EOT;
?>