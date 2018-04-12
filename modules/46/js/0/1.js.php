<?php
error_reporting(0);
$_46_ = array(
	'expire' => false,
	'id' => 1,
	'charset' => 'utf-8',
	'postfix' => '',
);

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
?>
<?php
$_46_['js_content'] = '<div id="p8_46_7_l" style="margin-left: px; position: absolute; top: 100px; left: 0px; width: 110px; height: 300px;"><div style="position: absolute; top: 3px; right: 3px; cursor: pointer; width: 18px; height: 18px; background: url(http://localhost:8080/jt/images/close.gif) no-repeat 0 -18px;"></div><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%"><param name="allowScriptAccess" value="sameDomain" /><param name="movie" value="http://localhost:8080/jt/modules/46/clicker.swf" /><param name="quality" value="high" /><param name="scale" value="noscale" /><param name="salign" value="lt" /><param name="bgcolor" value="#ffffff" /><param name="FlashVars" value="v_swf=http://localhost:8080/jt/attachment/core/46/2010_12/13_15/d22a4e61531cd26d.swf&v_url=http%3A%2F%2Flocalhost%3A8080%2Fjt%2Findex.php%2F46-jump%3Fid%3D1%26bid%3D7%26postfix%3D%26url%3Dhttp%253A%252F%252Fwww.php168.net%252Fhtml%252F16%252F" /><param name="wmode" value="transparent" /><embed src="http://localhost:8080/jt/modules/46/clicker.swf" wmode="transparent" quality="high" scale="noscale" salign="lt" bgcolor="#ffffff" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" FlashVars="v_swf=http://localhost:8080/jt/attachment/core/46/2010_12/13_15/d22a4e61531cd26d.swf&v_url=http%3A%2F%2Flocalhost%3A8080%2Fjt%2Findex.php%2F46-jump%3Fid%3D1%26bid%3D7%26postfix%3D%26url%3Dhttp%253A%252F%252Fwww.php168.net%252Fhtml%252F16%252F" /></object></div><div id="p8_46_7_r" style="margin-right: px; position: absolute;  top: 100px; right: 0px; width: 110px; height: 300px;"><div style="position: absolute; top: 3px; right: 3px; cursor: pointer; width: 18px; height: 18px; background: url(http://localhost:8080/jt/images/close.gif) no-repeat 0 -18px;"></div><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%"><param name="allowScriptAccess" value="sameDomain" /><param name="movie" value="http://localhost:8080/jt/modules/46/clicker.swf" /><param name="quality" value="high" /><param name="scale" value="noscale" /><param name="salign" value="lt" /><param name="bgcolor" value="#ffffff" /><param name="FlashVars" value="v_swf=http://localhost:8080/jt/attachment/core/46/2010_12/13_15/d22a4e61531cd26d.swf&v_url=http%3A%2F%2Flocalhost%3A8080%2Fjt%2Findex.php%2F46-jump%3Fid%3D1%26bid%3D7%26postfix%3D%26url%3Dhttp%253A%252F%252Fwww.php168.net%252Fhtml%252F16%252F" /><param name="wmode" value="transparent" /><embed src="http://localhost:8080/jt/modules/46/clicker.swf" wmode="transparent" quality="high" scale="noscale" salign="lt" bgcolor="#ffffff" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" FlashVars="v_swf=http://localhost:8080/jt/attachment/core/46/2010_12/13_15/d22a4e61531cd26d.swf&v_url=http%3A%2F%2Flocalhost%3A8080%2Fjt%2Findex.php%2F46-jump%3Fid%3D1%26bid%3D7%26postfix%3D%26url%3Dhttp%253A%252F%252Fwww.php168.net%252Fhtml%252F16%252F" /></object></div>';

$_46_['js'] = '
(function(){
var l = document.getElementById(\'p8_46_7_l\');
var r = document.getElementById(\'p8_46_7_r\');

l.getElementsByTagName(\'div\')[0].onclick = function(){
l.style.display = \'none\';
r.style.display = \'none\';
};
r.getElementsByTagName(\'div\')[0].onclick = function(){
l.style.display = \'none\';
r.style.display = \'none\';
};

if(/msie 6/i.test(navigator.userAgent)){
//god damn ie6
l.style.position = \'absolute\';
r.style.position = \'absolute\';
window.attachEvent(\'onscroll\', function(){
setTimeout(function(){
l.style.top = (document.documentElement.scrollTop || document.body.scrollTop) + 100 +\'px\';
r.style.top = (document.documentElement.scrollTop || document.body.scrollTop) + 100 +\'px\';
}, 200);
});
}else{
l.style.position = \'fixed\';
r.style.position = \'fixed\';
}

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