<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$P8LANG['prompt_message']}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="{$RESOURCE}/js/util.js"></script>
<style type="text/css">
*{ word-break:break-all }
body{ color:#000; font-size:12px; font-family:"宋体", Arial, Times; text-align:left; line-height:120%; background:#fff; }
body, ul, li, h3 { margin:0px; padding:0px; }
ul, li { list-style:none; }
.big{text-align:center; margin:15px 2px 0 2px}
.big span {padding:2px 10px; display:inline-block; }
a:link, a:visited { color:#1E62B0; text-decoration:none; }
a:hover { color:#ff0000; text-decoration:underline; }

.wrapper { width:500px; padding:3px; border:1px solid #48AEE0; background:#82D1F8; position: absolute; }
.container { padding:15px; background:#fff; }
.container h3 { font-size:14px; }
.container ul { font-size:14px; margin:15px; } 
.container ul.buttons { text-align:center; margin:0px; } 
</style>
</head>
<body>
<div class="wrapper">
<div class="container">
<h3>{$P8LANG['prompt_message']}</h3>
EOT;
if(empty($messagedb)){
print <<<EOT

<ul>
$message 
</ul>
<ul class="buttons">
EOT;
if($forward && $timeout *= 1000){
print <<<EOT


<a id="forward" href="$forward">{$P8LANG['redirecting']}</a>
<script type="text/javascript">
setTimeout(_go, $timeout);
function _go(){
window.location.href='$forward';
}
</script>
EOT;
}elseif($goback){
print <<<EOT

<script type="text/javascript">
function _go(){
history.back(-1);
}
</script>

<a id="forward" href="javascript:_go();">{$P8LANG['back']}</a>
EOT;
}
print <<<EOT


</ul>
EOT;
}else{
print <<<EOT

<ul class="buttons">
{$P8LANG['done']} 
</ul>
<div class="big">
EOT;
$__t_foreach = @$messagedb;
if(!empty($__t_foreach)){
foreach($__t_foreach as $key => $val){
print <<<EOT

<span>$val</span>
EOT;
}
}

print <<<EOT

</div>
EOT;
if($forward && $timeout){
print <<<EOT

<div class="big"><a id="forward" href="$forward">{$P8LANG['redirecting']}</a>
<script type="text/javascript">
setTimeout("_go()",$timeout);
function _go(){
window.location.href='$forward';
}
</script>
</div>	
EOT;
}
}
print <<<EOT

</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
element_to_center($('.wrapper'));
$(document).keydown(function(e){
if(e.keyCode == 32){
_go();
}
});
});
</script>
</body>
</html>
EOT;
?>