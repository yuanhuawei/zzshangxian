<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<div id="play_{$label['id']}" style="width:{$swidth}px;height:{$sheight}px; overflow:hidden; overflow: hidden;position:relative;">
<ul style="position:absolute;">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li style="float:left"><a href="$value[url]" target="_blank"><img src="$value[frame]" alt="$value[title]" width="{$swidth}" height="{$sheight}"/></a></li>
EOT;
}
}

print <<<EOT

</ul>
</div>
<script type="text/javascript">
(function(){
var playdiv = $('#play_{$label['id']}');
var w = {$swidth};
var speed = 3000;
var c = playdiv.find('li').size();
playdiv.find('ul').width(w * c);
t = setInterval(showImg, speed);
o = w;
function showImg(){
playdiv.find('ul').animate({left: '-'+ o +'px'}, "slow");
o += w;
if(o>=w * c){o = 0;}
}
})();
</script>
EOT;
?>