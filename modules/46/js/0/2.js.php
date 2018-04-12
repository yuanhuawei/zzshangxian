<?php
error_reporting(0);
$_46_ = array(
	'expire' => false,
	'id' => 2,
	'charset' => 'utf-8',
	'postfix' => '',
);

$_46_['time'] = time();
if(false){
	$_46_['expire'] = true;
	//refresh
	$_REQUEST['_no_session'] = true;
	require_once dirname(__FILE__) .'/../../../../inc/init.php';
	$_46_module = $core->load_module('46');
	$_46_['ret'] = $_46_module->js($_46_['id'], $_46_['postfix']);
	$_46_['js_content'] = $_46_['ret']['js_content'];
	$_46_['js'] = $_46_['ret']['js'];
	
	ob_start();
}else{
	if(!empty($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == 1585720568){
	//not modified 304
	header('Etag: '. 1585720568, true, 304);
	exit;
}
$gmt = gmdate('D, d M Y H:i:s', 1585720568) .' GMT';
//header('Last Modified: '. $gmt);
//header('Expires: '. $gmt);
header('Etag: '. 1585720568);
//exit;
}
?>
<?php
$_46_['js_content'] = '<p></p><div id="p8_46_5" style="overflow: hidden; width: 957px; height: 0px; margin: auto; display: none;" align="center"><a href="http://localhost:8080/jt/index.php/46-jump?id=2&postfix=&url=345&bid=5" target="_blank"><img src="http://localhost:8080/jt/attachment/core/46/2012_08/30_01/cd561aa4351d190c.jpg" width="957" height="335" title="" /></a></div>';

$_46_['js'] = '
(function(){

var cookies = document.cookie.split(\'; \');
for(var i = 0; i < cookies.length; i++){
var tmp = cookies[i].split(\'=\');
//not expired
if(tmp[0] == \'p8_46_shwon_5\' && parseInt(tmp[1]) == 1585720568) return;
}

function setcookie( name, value, expires, path, domain, secure ) {
var today = new Date();

today.setTime( today.getTime() );
if ( expires ) {
expires = expires * 1000;
}
var expires_date = new Date( today.getTime() + expires );
var str = name +\'=\'+ escape( value ) +
(expires ? \';expires=\'+ expires_date.toGMTString() : \'\' ) + 
(path ? \';path=\' + path : \'\' ) +
(domain ? \';domain=\' + domain : \'\' ) +
(secure ? \';secure\' : \'\' );
document.cookie = str;
}

setcookie(\'p8_46_shwon_5\', 1585720568, 8640000);


var div = document.getElementById(\'p8_46_5\'), height = 335, interval;

function slide(type, step, callback){
var _height = parseInt(div.style.height.replace(/[^0-9\\-]/g, \'\'));
step += 10;
var val = (type == \'show\' ? _height + step : _height - step);
if(type == \'show\' && val >= height){
div.style.height = height +\'px\';

if(callback) callback();
return;
}else if(type == \'hide\' && val <= 0){
div.style.height = \'0px\';
div.style.display = \'none\';

if(callback) callback();
return;
}

div.style.height = val +\'px\';

interval = setTimeout(function(){ slide(type, step, callback); }, 150);
}

//document.body.insertBefore(div, document.body.firstChild);
div.style.display = \'\';

var timeout = setTimeout(function(){ slide(\'hide\', 20); }, 10000);

slide(\'show\', 20, function(){
div.onmouseover = function(){
clearTimeout(timeout);
};

div.onmouseout = function(){
timeout = setTimeout(function(){ slide(\'hide\', 20); }, 1000);
};
});

})();
';

if(isset($_GET['charset']) && $_GET['charset'] != $charset){
	header('Content-type: text/javascript; charset='. $_GET['charset']);
	$convert = true;
}else{
	header('Content-type: text/javascript; charset=utf-8');
}

if(!isset($js_php)) echo 'document.write(\''. $_46_['js_content'] .'\');'. $_46_['js'];
?>