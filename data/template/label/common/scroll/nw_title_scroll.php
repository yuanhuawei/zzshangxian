<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<ul class="label_ul_s" id="scroll_{$label['id']}" style="height: {$sheight}px;line-height:20px;overflow:hidden">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li style="$wf;">
<span class="fleft " style="font-size:12px; margin-right:10px;">[<a href="$value[category_url]" target="_blank">$value[category_name]</a>]</span><span class="label_datatime">
EOT;
echo date('Y-m-d', $value['timestamp']);
print <<<EOT
</span>·<a href="$value[url]" target="_blank" title="$value[full_title]">$value[title]</a>
</li>
EOT;
}
}

print <<<EOT

<li class="clear"></li>
</ul>
<script type="text/javascript">
(function(){
var this_Scroll = document.getElementById("scroll_{$label['id']}");
this_Scroll.innerHTML+=this_Scroll.innerHTML;
var ScrollTimer=0;
var MyMar = setInterval(Scroll,2500);
this_Scroll.onmouseover=function(){ clearInterval(MyMar) };
this_Scroll.onmouseout=function(){ MyMar=setInterval(Scroll,2500) };
function Scroll(){
this_Scroll.scrollTop++;
if(parseInt(this_Scroll.scrollTop)%20!=0) {
ScrollTimer=setTimeout(Scroll,10);
}else{
if(parseInt(this_Scroll.scrollTop)>=parseInt(this_Scroll.scrollHeight)/2) {
this_Scroll.scrollTop=0;
}
clearTimeout(ScrollTimer);
}
}
})()	
</script>
EOT;
?>