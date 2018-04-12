<?php

/**
* ��ͼƬ
* @param string $file �ļ�λ��
* @param string $ext ͼƬ����
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
* ��ȡͼƬ��Ϣ
* @param string $file �ļ�λ��
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
* ����ͼƬ
* @param resource $im �򿪵�ͼƬ��Դ
* @param string $file ������ļ�
* @param string $ext ͼƬ����
* @param int $quality ͼƬ����0 - 100
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
* ��������ͼ
* @param string $file ��������ͼ���ļ�
* @param int $width ���Կ��
* @param int $height ���Ը߶�
* @param int $quality ͼƬ����0 - 100
* @return bool
**/
function image_thumb($file, $dest, $width, $height, $keep_scale = true, $quality = 75){
	
	$info = get_image_info($file);
	if(empty($info)) return false;
	
	$src_im = &open_image($file, $info['ext']);
	if(!$src_im) return false;
	
	if($keep_scale){
		//����������
		$scale = $width / $info['width'];
		$height = $info['height'] * $scale;
	}
	
	if($width > $info['width'] || $height > $info['height'] && $info['ext'] != 'gif'){
		//����ͼ���ܱ�ԭͼ�ߴ��,������,GIF�����ɵ�һ��ͼ
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
* ����ͼƬ
* @param string $file Դ�ļ�
* @param string $dest �����ļ�
* @param int $x X��
* @param int $y Y��
* @param int $width ��
* @param int $height ��
* @param int $quality ����
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
* ����ˮӡ
* @param string $file ����ˮӡ���ļ�
* @param string $watermark ˮӡͼƬ�ļ�
* @param int $position ˮӡλ��,С���̵����ֲַ�λ��
* @param int $quality ͼƬ����0 - 100
* @return bool
**/
function image_watermark($file, $dest, $watermark, $position = 3, $quality = 75){
	//���Դ�ļ��Ƿ����
	$info = get_image_info($file);
	if(empty($info)) return false;
	
	//���ˮӡ�ļ��Ƿ����
	$water_info = get_image_info($watermark);
	if(empty($water_info)) return false;
    
    $water_im = &open_image($watermark, $water_info['ext']);
	if(!$water_im) return false;
	
    $src_im = &open_image($file, $info['ext']);
    if(!$src_im) return false;
    
    //��ˮӡ��ͼƬ�ĳ��Ȼ��ȱ�ˮӡС150px
    if(
		($info['width'] < $water_info['width'] + 150) ||
		($info['height'] < $water_info['height'] + 150)
	) {
    	return false;
    }
	
    //С���̵�����λ�÷ֲ�
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