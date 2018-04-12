<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$core->CONFIG['page_charset']}" />
</head>
<body>

<div id="p8_46_$data[id]_l" style="margin-left: {$data['data']['margin']}px; position: absolute; top: {$data['data']['top']}px; left: 0px;">
<div style="position: absolute; top: 3px; right: 3px; cursor: pointer; width: 18px; height: 18px; background: url($RESOURCE/images/close.gif) no-repeat 0 -18px;"></div>
<a href="$url" target="_blank"><img width="$data[width]" height="$data[height]" src="{$data['data']['left']}" />
</div>

<div id="p8_46_$data[id]_r" style="margin-right: {$data['data']['margin']}px; position: absolute;  top: {$data['data']['top']}px; right: 0px;">
<div style="position: absolute; top: 3px; right: 3px; cursor: pointer; width: 18px; height: 18px; background: url($RESOURCE/images/close.gif) no-repeat 0 -18px;"></div>
<a href="$url" target="_blank"><img width="$data[width]" height="$data[height]" src="{$data['data']['right']}" /></a>
</div>

<script type="text/javascript">
(function(){

var l = document.getElementById('p8_46_$data[id]_l');
var r = document.getElementById('p8_46_$data[id]_r');
EOT;
if((!$data['data']['left'])){
print <<<EOT

l.style.display = 'none';
EOT;
}
if((!$data['data']['right'])){
print <<<EOT

r.style.display = 'none';
EOT;
}
print <<<EOT


l.getElementsByTagName('div')[0].onclick = function(){
l.style.display = 'none';
r.style.display = 'none';
};
r.getElementsByTagName('div')[0].onclick = function(){
l.style.display = 'none';
r.style.display = 'none';
};

if(/msie 6/i.test(navigator.userAgent)){
//god damn ie6
l.style.position = 'absolute';
r.style.position = 'absolute';

window.attachEvent('onscroll', function(){
setTimeout(function(){
l.style.top = (document.documentElement.scrollTop || document.body.scrollTop) + {$data['data']['top']} +'px';
r.style.top = (document.documentElement.scrollTop || document.body.scrollTop) + {$data['data']['top']} +'px';
}, 200);
});
}else{
l.style.position = 'fixed';
r.style.position = 'fixed';
}

})();
</script>

</body>
</html>
EOT;
?>