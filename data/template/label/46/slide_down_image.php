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
<p></p>
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<div id="p8_46_$data[id]" style="overflow: hidden; width: $data[width]px; height: 0px; margin: auto; display: none;" align="center">
<a href="$value[url]" target="_blank"><img src="$value[media]" width="$data[width]" height="$data[height]" title="{$data['data']['name']}" /></a>
</div>
EOT;
}
}

print <<<EOT


<script type="text/javascript">
(function(){

var cookies = document.cookie.split('; ');
for(var i = 0; i < cookies.length; i++){
var tmp = cookies[i].split('=');
//not expired
if(tmp[0] == 'p8_46_shwon_$data[id]' && parseInt(tmp[1]) == $timestamp) return;
}

function setcookie( name, value, expires, path, domain, secure ) {
var today = new Date();

today.setTime( today.getTime() );
if ( expires ) {
expires = expires * 1000;
}
var expires_date = new Date( today.getTime() + expires );
var str = name +'='+ escape( value ) +
(expires ? ';expires='+ expires_date.toGMTString() : '' ) + 
(path ? ';path=' + path : '' ) +
(domain ? ';domain=' + domain : '' ) +
(secure ? ';secure' : '' );
document.cookie = str;
}

setcookie('p8_46_shwon_$data[id]', $timestamp, 8640000);


var div = document.getElementById('p8_46_$data[id]'), height = $data[height], interval;

function slide(type, step, callback){
var _height = parseInt(div.style.height.replace(/[^0-9\\-]/g, ''));
step += 10;
var val = (type == 'show' ? _height + step : _height - step);
if(type == 'show' && val >= height){
div.style.height = height +'px';

if(callback) callback();
return;
}else if(type == 'hide' && val <= 0){
div.style.height = '0px';
div.style.display = 'none';

if(callback) callback();
return;
}

div.style.height = val +'px';

interval = setTimeout(function(){ slide(type, step, callback); }, 150);
}

//document.body.insertBefore(div, document.body.firstChild);
div.style.display = '';

var timeout = setTimeout(function(){ slide('hide', 20); }, 10000);

slide('show', 20, function(){
div.onmouseover = function(){
clearTimeout(timeout);
};

div.onmouseout = function(){
timeout = setTimeout(function(){ slide('hide', 20); }, 1000);
};
});

})();
</script>

</body>
</html>
EOT;
?>