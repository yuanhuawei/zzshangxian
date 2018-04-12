<?php
error_reporting(0);
$_46_ = array(
	'expire' => false,
	'id' => 7,
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
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="flying" style="width:138px;height:123px;position: absolute;overflow:hidden;z-index:9999">
<a href="" target="_blank"><img width="138" height="123" src="" title="" border="0" /></a>
<span style="top:2px;right:2px;cursor:pointer;position: absolute;width: 18px; height: 18px; background: url(http://localhost:8080/jt/images/close.gif) no-repeat 0 -18px;" onclick="$('#flying').hide();"></span>
</div>
<script type="text/javascript">
(function(){
	var height = $(window).height(); 
	var width = $(window).width();
	var Hoffset = $('#flying').height(); 
	var Woffset = $('#flying').width(); 
	var xPos = (width-Woffset)/2; 
	var yPos = (height-Hoffset)/2; 
	var step = 1; 
	var delay = 30;
	var yon = 0;
	var xon = 0;
	var pause = true; 
	var interval; 
	var interval = setInterval(changePos, delay);
	$('#flying').hover(function(){ clearInterval(interval); },function(){ interval = setInterval(changePos, delay);});
	function changePos() {
		$('#flying').css({left:xPos+$(window).scrollLeft(),top:yPos+$(window).scrollTop()});																																																								
		if (yon) {yPos = yPos + step; } 
		else {yPos = yPos - step; } 
		if (yPos < 0) { yon = 1;yPos = 0; } 
		if (yPos >= (height - Hoffset)) { yon = 0;yPos = (height - Hoffset);}																																																																	
		if (xon) {xPos = xPos + step; } 
		else {xPos = xPos - step; } 
		if (xPos < 0) { xon = 1;xPos = 0; } 
		if (xPos >= (width - Woffset-20)) { xon = 0;xPos = (width - Woffset-20); }
	}
})()
</script>
</body></html>
<?php
if($_46_['expire']){
	ob_end_clean();
	echo $_46_['ret']['content'];
}
?>