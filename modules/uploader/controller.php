<?php
defined('PHP168_PATH') or die();

class P8_Uploader_Controller extends P8_Controller{

var $filter;
var $_system;
var $_module;

function __construct(&$obj){
	parent::__construct($obj);
	
	
	//�����ϴ����ǹ������ǿյ�,���ý�ɫ�Ĺ�����,�����ɫҲ�ǿյ�,�����Ĭ�ϵĹ�����
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
* �ϴ�
* @param array $FILES Ҫ�ϴ����ļ�����,һ����Դ��$_FILES
* @param array $filter �ļ�������
* @return array �Ѿ��ϴ����ļ�����
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
		//���
		foreach($data['files']['name'] as $k => $v){
			$files[] = array(
				'name' => $data['files']['name'][$k],
				'tmp_name' => $data['files']['tmp_name'][$k],
				'type' => $data['files']['type'][$k],
				'size' => $data['files']['size'][$k],
			);
		}
	}else if(!empty($data['files'])){
		//����
		$files[] = $data['files'];
	}
	unset($data['files']);
	
	//�����������ļ�����,��С
	foreach($files as $k => $v){
		if(empty($data['capture']) && !is_uploaded_file($files[$k]['tmp_name'])){
			//������ǲ�ץ�����ļ�,���ֲ����ϴ����ļ�
			unset($files[$k]);
			continue;
		}
		
		$ext = file_ext($v['name']);
		$files[$k]['ext'] = $ext;
		
		//�����ļ�����,��С, �������Ҳ�����ϴ�php�ļ�
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
* ��ץ�����ļ�
* @param array $file Ҫ��ץ�ļ���URL����
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
		//�������Ҳ�����ϴ�php�ļ�
		if(
			!preg_match('/\.php.*/i', $_ext) &&
			isset($this->filter[$ext]) && $tmp = @file_get_contents($v)
		){
			
			//��ʱ�ļ�
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
* ����Ƿ������ϴ�
**/
function check_enabled(){
	
	if(empty($this->filter)){
		return false;
	}
	
	if($this->_module !== ''){
		$bool = isset($this->model->CONFIG['enables'][$this->_system][$this->_module]);
		//ģ���ʲ������ϴ�
	}else{
		$bool = isset($this->model->CONFIG['enables'][$this->_system]['']);
		//ϵͳ�ʲ������ϴ�
	}
	
	return $bool;
}

function delete($system, $module, $cond){
	
}

}