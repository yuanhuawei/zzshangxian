<?php
header('Pragma: no-cache');
header('Cache-Control: no-cache, must-revalidate');

require dirname(__FILE__) .'/../inc/init.php';

$rands = 'ABCDEHKMNPRSTUWXY2345678';
$code = '';
for($i = 0; $i < 4; $i++){
	$code .= $rands{mt_rand(0, 23)};
}
//$code = (string)mt_rand(1000, 9999);

$width = 48;
$height = 22;

$im = imagecreate($width, $height);


for($i = 0; $i < 10; $i++){
	$fontcolor = imagecolorallocate($im, mt_rand(128, 255), mt_rand(128, 255), mt_rand(128, 255));
	imagearc($im, mt_rand(-10, $width), mt_rand(-10, $height), mt_rand(30, 300), mt_rand(20, 200), 55, 44, $fontcolor);
}

for($i = 0; $i < 4; $i++){
	imagestring(
		$im, 5,
		$i*10+6+mt_rand(-2, 2), mt_rand(1,9),
		$code{$i}, imagecolorallocate($im, mt_rand(0, 128), mt_rand(0, 128), mt_rand(0, 128))
	);
}

for($i = 0; $i < 40; $i++){
	imagesetpixel($im, mt_rand(0, 38), mt_rand(0, 15), imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)));
}

//SESSION
$_P8SESSION['captcha'] = strtolower($code);

header("Content-type: image/jpeg");
imagejpeg($im);
imagedestroy($im);