<?php
defined('PHP168_PATH') or die();

class P8_Uploader_Controller extends P8_Controller{

var $filter;
var $_system;
var $_module;

function __construct(&$obj){
	parent::__construct($obj);
	
	
	//允许上传但是过滤器是空的,先用角色的过滤器,如果角色也是空的,最后用默认的过滤器
	if(!empty($this->model->CONFIG['role_filters'][$this->core->ROLE]['filter'])){
		$this->filter = &$this->model->CONFIG['role_filters'][$this->core->ROLE]['filter'];
	}else{
		$this->filter = &$this->model->CONFIG['filter'];
	}
}

function P8_Uploader_Controller(&$obj){
	$this->__construct($obj);
}

function set($system = 'core', $module = ''){
	$this->_system = $system;
	$this->_module = $module;
	$this->model->set($system, $module);
}

/**
* 上传
* @param array $FILES 要上传的文件数组,一般来源是$_FILES
* @param array $filter 文件过滤器
* @return array 已经上传的文件数组
**/
function upload($data){
	
	$files = array();
	$data['thumb_width'] = isset($data['thumb_width']) ? intval($data['thumb_width']) : 0;
	$data['thumb_width'] = max(0, $data['thumb_width']);
	$data['thumb_height'] = isset($data['thumb_height']) ? intval($data['thumb_height']) : 0;
	$data['thumb_height'] = max(0, $data['thumb_height']);
	
	$data['cthumb_width'] = isset($data['cthumb_width']) ? intval($data['cthumb_width']) : 0;
	$data['cthumb_width'] = max(0, $data['cthumb_width']);
	$data['cthumb_height'] = isset($data['cthumb_height']) ? intval($data['cthumb_height']) : 0;
	$data['cthumb_height'] = max(0, $data['cthumb_height']);
	
	if(!empty($data['files']) && is_array($data['files']['name'])){
		//多个
		foreach($data['files']['name'] as $k => $v){
			$files[] = array(
				'name' => $data['files']['name'][$k],
				'tmp_name' => $data['files']['tmp_name'][$k],
				'type' => $data['files']['type'][$k],
				'size' => $data['files']['size'][$k],
			);
		}
	}else if(!empty($data['files'])){
		//单个
		$files[] = $data['files'];
	}
	unset($data['files']);
	
	//在这里限制文件类型,大小
	foreach($files as $k => $v){
		if(empty($data['capture']) && !is_uploaded_file($files[$k]['tmp_name'])){
			//如果不是捕抓来的文件,但又不是上传的文件
			unset($files[$k]);
			continue;
		}
		
		$ext = file_ext($v['name']);
		$files[$k]['ext'] = $ext;
		
		//过滤文件类型,大小, 无论如何也不能上传php文件
		$_ext = strtolower($ext);
		if(
			preg_match('/\.?php.*/i', $_ext) ||
			!isset($this->filter[$_ext]) || $v['size'] > $this->filter[$_ext]
			|| in_array($_ext,$this->model->deny)
		){
			unset($files[$k]);
		}
	}
	
	return $this->model->upload(array(
		'files' => $files,
		'thumb_width' => $data['thumb_width'],
		'thumb_height' => $data['thumb_height'],
		'cthumb_width' => $data['cthumb_width'],
		'cthumb_height' => $data['cthumb_height'],
		'image_cut' => empty($data['image_cut']) ? false : true,
		'capture' => empty($data['capture']) ? false : true
	));
}

/**
* 捕抓网络文件
* @param array $file 要捕抓文件的URL数组
**/
function capture($data){
	
	$data['thumb_width'] = isset($data['thumb_width']) ? intval($data['thumb_width']) : 0;
	$data['thumb_width'] = max(0, $data['thumb_width']);
	$data['thumb_height'] = isset($data['thumb_height']) ? intval($data['thumb_height']) : 0;
	$data['thumb_height'] = max(0, $data['thumb_height']);
	
	$data['cthumb_width'] = isset($data['cthumb_width']) ? intval($data['cthumb_width']) : 0;
	$data['cthumb_width'] = max(0, $data['cthumb_width']);
	$data['cthumb_height'] = isset($data['cthumb_height']) ? intval($data['cthumb_height']) : 0;
	$data['cthumb_height'] = max(0, $data['cthumb_height']);
	
	$files = array(
		'name' => array(),
		'tmp_name' => array(),
		'size' => array(),
		'type' => array()
	);
	
	$today = CACHE_PATH .'tmp/attachment/'. date('Y-m-d', P8_TIME) .'/';
	md($today);
	
	foreach((array)$data['files'] as $v){
		$ext = file_ext($v);
		$_ext = strtolower($ext);
		//无论如何也不能上传php文件
		if(
			!preg_match('/\.php.*/i', $_ext) &&
			isset($this->filter[$ext]) && $tmp = @file_get_contents($v)
		){
			
			//临时文件
			$tmp_file = $today . unique_id();
			write_file($tmp_file, $tmp);
			
			$files['name'][] = basename($v);
			$files['tmp_name'][] = $tmp_file;
			$files['size'][] = strlen($tmp);
			$files['type'][] = function_exists('mime_content_type') ? 
				($m = mime_content_type($tmp_file) ? $m : 'application/octet-stream' ) :
				'application/octet-stream';
		}
	}
	
	return $this->upload(array(
		'files' => $files,
		'capture' => true,
		'image_cut' => empty($data['image_cut']) ? false : true,
		'thumb_width' => $data['thumb_width'],
		'thumb_height' => $data['thumb_height'],
		'cthumb_width' => $data['cthumb_width'],
		'cthumb_height' => $data['cthumb_height']
	));
}

/**
* 检查是否允许上传
**/
function check_enabled(){
	
	if(empty($this->filter)){
		return false;
	}
	
	if($this->_module !== ''){
		$bool = isset($this->model->CONFIG['enables'][$this->_system][$this->_module]);
		//模型允不允许上传
	}else{
		$bool = isset($this->model->CONFIG['enables'][$this->_system]['']);
		//系统允不允许上传
	}
	
	return $bool;
}

function delete($system, $module, $cond){
	
}

}