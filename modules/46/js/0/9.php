<?php
error_reporting(0);
$_46_ = array(
	'expire' => false,
	'id' => 9,
	'charset' => 'utf-8',
	'postfix' => '',
);

if(!empty($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == 1585720569){
	//not modified 304
	header('Etag: '. 1585720569, true, 304);
	exit;
}
$gmt = gmdate('D, d M Y H:i:s', 1585720569) .' GMT';
//header('Last Modified: '. $gmt);
//header('Expires: '. $gmt);
header('Etag: '. 1585720569);
//exit;
?>
<?php
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<div id="p8_46_10_l" style="margin-left: 10px; position: absolute; top: 180px; left: 0px;">
<div style="position: absolute; top: 3px; right: 3px; cursor: pointer; width: 18px; height: 18px; background: url(http://localhost:8080/jt/images/close.gif) no-repeat 0 -18px;"></div>
<a href="http://www.php168.net/html/16/" target="_blank"><img width="108" height="300" src="" />
</div>

<div id="p8_46_10_r" style="margin-right: 10px; position: absolute;  top: 180px; right: 0px;">
<div style="position: absolute; top: 3px; right: 3px; cursor: pointer; width: 18px; height: 18px; background: url(http://localhost:8080/jt/images/close.gif) no-repeat 0 -18px;"></div>
<a href="http://www.php168.net/html/16/" target="_blank"><img width="108" height="300" src="http://localhost:8080/jt/attachment/core/46/2015_01/06_20/d6f07fc0265bae06.jpg" /></a>
</div>

<script type="text/javascript">
(function(){

var l = document.getElementById('p8_46_10_l');
var r = document.getElementById('p8_46_10_r');
l.style.display = 'none';

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
l.style.top = (document.documentElement.scrollTop || document.body.scrollTop) + 180 +'px';
r.style.top = (document.documentElement.scrollTop || document.body.scrollTop) + 180 +'px';
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
<?php
if($_46_['expire']){
	ob_end_clean();
	echo $_46_['ret']['content'];
}
?>