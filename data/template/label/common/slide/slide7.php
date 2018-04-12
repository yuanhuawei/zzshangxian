<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<style style="text/css">
#play_{$label['id']} { width:{$swidth}px;	height:{$sheight}px;    position: relative;   z-index: 2;}
#play_{$label['id']} .clearfix li {  display: none;    position: absolute;   overflow: hidden;    width:{$swidth}px;	height:{$sheight}px;}
#play_{$label['id']} .clearfix li img { width:{$swidth}px;	height:{$sheight}px;    overflow: hidden; }
#play_{$label['id']} .jsNav { position:absolute;right:40px;bottom:25px;z-index: 111;}
#play_{$label['id']} .jsNav li { background-color: #C4CAE0;cursor:pointer;    display: inline-block;    float: left;    height: 7px;    line-height: 0;    margin-left: 5px;    text-indent: -9999px;    width: 7px;}
#play_{$label['id']} .jsNav li.over { background-color: #505050;}
</style>
<div id="play_{$label['id']}">
<ul class="clearfix">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li><a href="{$value['url']}"><img src="{$value['frame']}" width="$swidth" height="$sheight"></a></li>
EOT;
}
}

print <<<EOT

</ul>
<ul class="jsNav" id="jsNav_{$label['id']}">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $key => $value){
print <<<EOT

<li>
EOT;
echo  $key+1;
print <<<EOT
</li>
EOT;
}
}

print <<<EOT

</ul>
</div>
<script type="text/javascript">
(function () {
var num = $("#jsNav_{$label['id']} li").length;
$("#play_{$label['id']} ul li:first").css("display", "block");
$("#jsNav_{$label['id']} li:first").addClass("over");
var curr = 0;
$("#jsNav_{$label['id']} li").each(function (i) {
$(this).click(function () {
curr = i;
$("#play_{$label['id']} ul li").eq(i).css("z-index", "10").siblings("li").css("z-index", "1");
$("#play_{$label['id']} ul li").eq(i).fadeIn(1500).siblings("li").fadeOut(1500);
$(this).siblings("li").removeClass("over").end().addClass("over");
return false;
});
});
//自动翻
var timer = setInterval(function () {
todo = (curr + 1) % num;
$("#jsNav_{$label['id']} li").eq(todo).click();
}, 9000);

//鼠标悬停在触发器上时停止自动翻
$("#jsNav_{$label['id']} li").hover(
function () {
clearInterval(timer);
},
function () {
timer = setInterval(function () {
todo = (curr + 1) % num;
$("#jsNav_{$label['id']} li").eq(todo).click();
}, 5000);
}
);
})();
</script>
EOT;
?>