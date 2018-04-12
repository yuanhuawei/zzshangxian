<?php

/**
* 打开图片
* @param string $file 文件位置
* @param string $ext 图片类型
* @return resource
**/
function &open_image($file, $ext){
	$func = 'imagecreatefrom'. $ext;
	if(!function_exists($func)){
		$ret = false;
		return $ret;
	}
	
	$im = $func($file);
	return $im;
}

/**
* 获取图片信息
* @param string $file 文件位置
* @return array
**/
function get_image_info($file){
	$info = @getimagesize($file);
	
	if(empty($info)) return null;
	
	$info['width'] = $info[0];
	$info['height'] = $info[1];
	
	switch($info[2]){
		case 1: $info['ext'] = 'gif'; break;
		case 2: $info['ext'] = 'jpeg'; break;
		case 3: $info['ext'] = 'png'; break;
	}
	unset($info[0], $info[1]);
	return $info;
}

/**
* 保存图片
* @param resource $im 打开的图片资源
* @param string $file 保存的文件
* @param string $ext 图片类型
* @param int $quality 图片质量0 - 100
**/
function save_image(&$im, $file, $ext, $quality = 75){
	$func = 'image'. $ext;
	if(!function_exists($func)) return false;
	
	if ($ext == 'jpeg'){
		return $func($im, $file, $quality);
	}else{
		return $func($im, $file);
	}
}

/**
* 生成缩略图
* @param string $file 生成缩略图的文件
* @param int $width 缩略宽度
* @param int $height 缩略高度
* @param int $quality 图片质量0 - 100
* @return bool
**/
function image_thumb($file, $dest, $width, $height, $keep_scale = true, $quality = 75){
	
	$info = get_image_info($file);
	if(empty($info)) return false;
	
	$src_im = &open_image($file, $info['ext']);
	if(!$src_im) return false;
	
	if($keep_scale){
		//按比例生成
		$scale = $width / $info['width'];
		$height = $info['height'] * $scale;
	}
	
	if($width > $info['width'] || $height > $info['height'] && $info['ext'] != 'gif'){
		//缩略图不能比原图尺寸大,不生成,GIF的生成第一张图
		return false;
	}
	
	$dest = $dest ? $dest : $file .'.thumb.jpg';
	
	$dest_im = imagecreatetruecolor($width, $height);
	
	if ($info['ext'] == 'png') {
		
		$transparency = imagecolorallocatealpha($dest_im, 0, 0, 0, 127);
		imagealphablending($dest_im, FALSE);
		imagefilledrectangle($dest_im, 0, 0, $width, $height, $transparency);
		imagealphablending($dest_im, TRUE);
		imagesavealpha($dest_im, TRUE);
		
	}else if ($info['ext'] == 'gif') {
		// If we have a specific transparent color.
		$transparency_index = imagecolortransparent($src_im);
		$width = min($width, $info['width']);
		$height = min($height, $info['height']);
		
		if ($transparency_index >= 0) {
			// Get the original image's transparent color's RGB values.
			$transparent_color = @imagecolorsforindex($src_im, $transparency_index);
			// Allocate the same color in the new image resource.
			$transparency_index = imagecolorallocate($dest_im, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
			// Completely fill the background of the new image with allocated color.
			imagefill($dest_im, 0, 0, $transparency_index);
			// Set the background color for new image to transparent.
			imagecolortransparent($dest_im, $transparency_index);
			// Find number of colors in the images palette.
			$number_colors = imagecolorstotal($src_im);
			// Convert from true color to palette to fix transparency issues.
			imagetruecolortopalette($dest_im, TRUE, $number_colors);
		}
	}
	
	imagecopyresampled(
		$dest_im, $src_im,
		0, 0, 0, 0,
		$width, $height, $info['width'], $info['height']
	);
	
	$status = save_image($dest_im, $dest, $info['ext'], $quality);
	
	imagedestroy($src_im);
	imagedestroy($dest_im);
	return $status;
}

/**
* 剪裁图片
* @param string $file 源文件
* @param string $dest 保存文件
* @param int $x X轴
* @param int $y Y轴
* @param int $width 宽
* @param int $height 高
* @param int $quality 质量
**/
function image_cut($file, $dest, $x, $y, $width, $height, $quality = 75){
	$info = get_image_info($file);
	if(empty($info)) return false;
	
	$im = &open_image($file, $info['ext']);
	if(!$im) return false;
	
	$res = imagecreatetruecolor($width, $height);
	imagecopy($res, $im, 0, 0, $x, $y, $width, $height);
	$status = save_image($res, $dest, $info['ext'], $quality);

	imagedestroy($res);
	imagedestroy($im);
	
	return $status;
}

/**
* 生成水印
* @param string $file 生成水印的文件
* @param string $watermark 水印图片文件
* @param int $position 水印位置,小键盘的数字分布位置
* @param int $quality 图片质量0 - 100
* @return bool
**/
function image_watermark($file, $dest, $watermark, $position = 3, $quality = 75){
	//检查源文件是否存在
	$info = get_image_info($file);
	if(empty($info)) return false;
	
	//检查水印文件是否存在
	$water_info = get_image_info($watermark);
	if(empty($water_info)) return false;
    
    $water_im = &open_image($watermark, $water_info['ext']);
	if(!$water_im) return false;
	
    $src_im = &open_image($file, $info['ext']);
    if(!$src_im) return false;
    
    //加水印的图片的长度或宽度比水印小150px
    if(
		($info['width'] < $water_info['width'] + 150) ||
		($info['height'] < $water_info['height'] + 150)
	) {
    	return false;
    }
	
    //小键盘的数字位置分布
	switch($position) {
	
	case 7:
		$posx = 0;
		$posy = 0;
	break;
	
	case 9:
		$posx = $info['width'] - $water_info['width'];
		$posy = 0;
	break;
	
	case 1:
		$posx = 0;
		$posy = $info['height'] - $water_info['height'];
	break;
	
	case 5:
		$posx = ($info['width'] - $water_info['width'])/2;
		$posy = ($info['height'] - $water_info['height'])/2;
	break;
	
	case 3:
		$posx = $info['width'] - $water_info['width'];
		$posy = $info['height'] - $water_info['height'];
	break;
	
	}
	
	imagealphablending($src_im, true);
	
	imagecopy($src_im, $water_im, $posx, $posy, 0, 0, $water_info['width'], $water_info['height']);
	$status = save_image($src_im, $dest, $info['ext'], $quality);
	
	imagedestroy($water_im);
	imagedestroy($src_im);
	
	return $status;
}