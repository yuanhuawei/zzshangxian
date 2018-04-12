<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<style type="text/css">
#banner_index_{$label['id']}{height:{$sheight}px;overflow:hidden;width: {$swidth}px; position:relative; margin:auto;}
#banner_index_{$label['id']} .btn,.banner_pro .bBtn{position: absolute;top:160px;width:40px;height: 46px;display: block;z-index: 3;}
#banner_index_{$label['id']} .btnPre,.banner_pro .bPre{background: url({$RESOURCE}/skin/label/left_btnOUT.png) no-repeat 0 0;left:20px;}
#banner_index_{$label['id']} .btnNext,.banner_pro .bNext{background: url({$RESOURCE}/skin/label/right_btnOUT.png) no-repeat 0 0;right: 20px;}
#banner_index_{$label['id']} .btnPre:hover,.banner_pro .bPre:hover{background: url({$RESOURCE}/skin/label/left_btn.png) no-repeat 0 0;left:20px;}
#banner_index_{$label['id']} .btnNext:hover,.banner_pro .bNext:hover{background: url({$RESOURCE}/skin/label/right_btn.png) no-repeat 0 0;right: 20px;}
#banner_index_{$label['id']} .banner_wrap{position: absolute;left:0px;top: 0px; z-index: 2;}
#banner_index_{$label['id']} .banner_wrap li{width: {$swidth}px;float: left;}
#banner_index_{$label['id']} .title_bg{z-index:3; padding:10px 20px 20px 10px; position:absolute; left:10%; bottom:10%; background-color:#000; filter:alpha(opacity=40);	-moz-opacity:0.4;-khtml-opacity: 0.4;opacity: 0.4;	background:#000;}
#banner_index_{$label['id']} .title_bg a{color:#CF9B00; font-size:24px; font-weight:500; font-family:微软雅黑;}
</style>
<div id="banner_index_{$label['id']}">
<a href="javascript:void(0);" class="btn btnPre" alt="left"></a>
<a href="javascript:void(0);" class="btn btnNext" alt="right"></a>
<ul class="banner_wrap">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li>
<a href="{$value['url']}" target="_blank"><img src="{$value['frame']}" width="$swidth" height="$sheight" alt="{$value['title']}"></a>

</li>
EOT;
}
}

print <<<EOT
 
</ul>
<span class="title_bg">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $key => $value){
print <<<EOT

<a href="{$value['url']}" target="_blank" style="display:
EOT;
if($key){
print <<<EOT
none
EOT;
}
print <<<EOT
">{$value['title']}</a>
EOT;
}
}

print <<<EOT
 
</span>
</div> 


<script type="text/javascript">
(function(){
var c = $('#banner_index_{$label['id']} .banner_wrap li').length,w = {$swidth},d = -c*w, temp = $('#banner_index_{$label['id']} .banner_wrap').html();timer =  setInterval(move_anti, 5000);
$('#banner_index_{$label['id']} .banner_wrap').css({width:7*c*w });
$(temp).appendTo($('#banner_index_{$label['id']} .banner_wrap'));
$(temp).prependTo($('#banner_index_{$label['id']} .banner_wrap'));
$('#banner_index_{$label['id']} .banner_wrap').css({left:d});

$('#banner_index_{$label['id']} .btn').click(function(){ clearInterval(timer);timer = null; move_anti($(this).attr('alt'))});

function move_anti(a){
if(a=='left'){ d +=w;	}else{	d -= w;	} 
$("#banner_index_{$label['id']} .banner_wrap").animate({left:d+'px'},	function(){ e=(-d/w)%c; $("#banner_index_{$label['id']} .title_bg a").eq(e).show().siblings().hide(); if(d>=0) d=-(2*c)*w; else if (d <= -(3*c-1)*w) d=-(c-1)*w;	$('#banner_index_{$label['id']} .banner_wrap').css({left:d}); if(!timer)timer =  setInterval(move_anti, 5000);} );	
}
})();
</script>
EOT;
?>