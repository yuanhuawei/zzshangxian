<?php
defined('PHP168_PATH') or die();

class P8_Uploader extends P8_Module{

var $table;
var $attachment_path;
var $ftp;
var $ftp_pool;
var $_system;
var $deny;

function __construct(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	$this->deny = array('php','exe','bat','msi','html','htm','asp','aspx','sh','js');
	$this->table = $this->system->TABLE_ .'attachment';
	$this->filter_table = $this->TABLE_ .'filter';
	$this->attachment_path = PHP168_PATH . $this->system->CONFIG['attachment']['path'] .'/';
	$this->ftp_pool = array();
	$this->_system = 'core';
}

function P8_Uploader(&$system, $name){
	$this->__construct($system, $name);
}

/**
* 设置当前模块使用哪个系统表
* @param string $system 系统名称,如果为空使用核心
**/
function set_system($system = 'core'){
	
	if($system == 'core'){
		$this->table = $this->core->TABLE_ .'attachment';
		$this->_system = 'core';
	}else if($sys_info = get_system($system)){
		$this->table = $sys_info['table_prefix'] .'attachment';
		$this->_system = $system;
	}
}

function set($system = 'core', $module = ''){
	if($system == 'core'){
		$this->table = $this->core->TABLE_ .'attachment';
		$this->_system = 'core';
	}else if($sys_info = get_system($system)){
		$this->table = $sys_info['table_prefix'] .'attachment';
		$this->_system = $system;
	}
	
	$this->_module = $module;
}

/**
* 模块配置,具体参数参见core
* ftp_config 为保护字段
**/
/* function set_config(
	$datas, 
	$protect_fields = array(	//FTP设置可以根据不同的站设置不同的FTP
		//'ftp_config' => 1
	),
	$ignore_fields = array(
		'_filter' => 1
	)
){
	parent::set_config($datas, $protect_fields, $ignore_fields);
} */

/**
* 返回FTP对象的引用
* @param array $config FTP的配置
* @return object FTP对象
**/
function &ftp($config){
	require_once PHP168_PATH .'inc/ftp.class.php';
	
	//以host:port/dir这种方式存储数组下标
	$str = "{$config['host']}:{$config['port']}/{$config['dir']}";
	
	if(isset($this->ftp_pool[$str])){
		
		$ftp = &$this->ftp_pool[$str];
		
	}else{
		$this->ftp_pool[$str] = new P8_Ftp(
			$config['host'],
			$config['port'],
			$config['user'],
			$config['password'],
			$config['dir'],
			$config['timeout'],
			$config['ssl']
		);
		$ftp = &$this->ftp_pool[$str];
		
		$ftp->connect();
	}
	
	return $ftp;
}

/**
* 上传文件
**/
function upload($data){
	
	global $UID;
	
	list($year, $month, $day, $hour) = explode('|', date('Y|m|d|H', P8_TIME));
	$path = $this->_system .'/'. ($this->_module ? $this->_module .'/' : '') .
		$year .'_'. $month .'/'. $day .'_'. $hour;
	
	$func = empty($data['capture']) ? 'move_uploaded_file' : 'rename';
	
	$ftp = null;
	//远程附件
	if(!empty($this->CONFIG['ftp_config']['enabled'])){
		$ftp = &$this->ftp($this->CONFIG['ftp_config']);
		$remote_att = &$this->core->CONFIG['attachment']['remote'];
		$att_url = $remote_att['server'][$remote = $remote_att['current']];
		
		$ftp->mkdir($ftp->dir . $path);
	}else{
		$att_url = $this->core->attachment_url;
		md($this->attachment_path . $path, true);
		$remote = 0;
	}
	
	$ret = array();
	foreach($data['files'] as $v){
		//唯一的文件
		$upload_file = $path .'/'. unique_id(16) .'.'. $v['ext'];
		$thumb = 0;
		
		$_ext = strtolower($v['ext']);
		
		if(
			!empty($this->CONFIG['thumb']['enabled']) || !empty($this->CONFIG['watermark']['enabled'])
		){
			
			//开启缩略图或水印
			
			switch($_ext){
			
			case 'jpg':
			case 'jpeg':
			case 'gif':
			case 'png':
				include_once PHP168_PATH .'inc/gd.func.php';
				
				$thumb_width = empty($data['thumb_width']) ? $this->CONFIG['thumb']['width'] : $data['thumb_width'];
				$thumb_height = empty($data['thumb_height']) ? $this->CONFIG['thumb']['height'] : $data['thumb_height'];
				$cthumb_width = empty($data['cthumb_width']) ? $this->CONFIG['cthumb']['width'] : $data['cthumb_width'];
				$cthumb_height = empty($data['cthumb_height']) ? $this->CONFIG['cthumb']['height'] : $data['cthumb_height'];
				
				$watermark = isset($data['watermark']) ? 
					($data['watermark'] ? true : false) :
					!empty($this->CONFIG['watermark']['enabled']);
				
				//生成缩略图,如果是剪裁图片的取消
				if(
					!empty($this->CONFIG['thumb']['enabled']) &&
					image_thumb(
						$v['tmp_name'], $thumb_file = $v['tmp_name'] .'.thumb.jpg',
						$thumb_width, $thumb_height, true,
						$this->CONFIG['thumb']['quality']
					)
				){
					
					//成功生成缩略图
					if($ftp){
						//把缩略图也传到FTP上
						$ftp->put($thumb_file, $ftp->dir . $upload_file .'.thumb.jpg');
						$ftp->chmod($ftp->dir . $upload_file .'.thumb.jpg', 0644);
					}else{
						//把缩略图上传
						rename($thumb_file, $this->attachment_path . $upload_file .'.thumb.jpg');
						@chmod($this->attachment_path . $upload_file .'.thumb.jpg', 0644);
					}
					$thumb = 1;
					@unlink($thumb_file);
					
					//内容页缩略图
					if(
						image_thumb(
							$v['tmp_name'], $thumb_file = $v['tmp_name'] .'.cthumb.jpg',
							$cthumb_width, $cthumb_height, true,
							$this->CONFIG['thumb']['quality']
						)
					){
						//内容页缩略图水印
						$watermark &&
						image_watermark(
							$thumb_file, $thumb_file,
							PHP168_PATH . $this->CONFIG['watermark']['file'],
							$this->CONFIG['watermark']['position'],
							$this->CONFIG['watermark']['quality']
						);
						
						//成功生成缩略图
						if($ftp){
							//把缩略图也传到FTP上
							$ftp->put($thumb_file, $ftp->dir . $upload_file .'.cthumb.jpg');
							$ftp->chmod($ftp->dir . $upload_file .'.cthumb.jpg', 0644);
						}else{
							//把缩略图上传
							rename($thumb_file, $this->attachment_path . $upload_file .'.cthumb.jpg');
							@chmod($this->attachment_path . $upload_file .'.cthumb.jpg', 0644);
						}
						$thumb = 2;
						@unlink($thumb_file);
					}
				}
				
				//水印
				$watermark &&
				image_watermark(
					$v['tmp_name'], $v['tmp_name'],
					PHP168_PATH . $this->CONFIG['watermark']['file'],
					$this->CONFIG['watermark']['position'],
					$this->CONFIG['watermark']['quality']
				);
				
			break;
			
			}
		}
		
		//上传(ftp)
		if($ftp){
			$status = $ftp->put($v['tmp_name'], $ftp->dir . $upload_file);
			$ftp->chmod($ftp->dir . $upload_file, 0644);
		}else{
			$status = $func($v['tmp_name'], $this->attachment_path . $upload_file);
			@chmod($this->attachment_path . $upload_file, 0644);
		}
		
		@unlink($v['tmp_name']);
		
		$system_info = get_system($this->_system);
		
		//有修改文件名的
		$v['alias'] = isset($v['alias']) ? $v['alias'] : $v['name'];
		
		//插入数据库
		if(
			$status &&
			$id = $this->DB_master->insert(
				$this->_system == 'core' ? $this->table : $system_info['table_prefix'] .'attachment',
				array(
					'module' => $this->_module,
					'uid' => $UID,
					'filename' => $v['alias'],
					'type' => $v['type'],
					'ext' => $_ext,
					'ip' => P8_IP,
					'size' => $v['size'],
					'path' => $upload_file,
					'thumb' => $thumb,
					'remote' => $remote,
					'timestamp' => P8_TIME
				),
				array('return_id' => true)
			)
		){
			$ret[] = array(
				'id' => $id,
				'name' => $v['alias'],
				'file' => $att_url .'/'. $upload_file,
				'size' => $v['size'],
				'thumb' => $thumb
			);
		}
	}
	
	return $ret;
}

function set_filter(&$data){
	//replace into
	return $this->DB_master->insert(
		$this->filter_table,
		$data,
		array(
			'replace' => true
		)
	);
}

/**
* 关联模块删除,实现删除关联附件
* @param object $obj 模块对象
* @param string $cond 条件
**/
function hook_delete(&$obj, $cond){
	
	$orig_table = $this->table;
	
	if($obj->system->name == 'core' && $obj->name == 'member'){
		//从会员模块传递过来的,删除各个系统的所有附件
		
		foreach($this->core->systems as $sys => $v){
			$_system = get_system($sys);
			if(!$_system['installed']) continue;
			
			$this->table = $_system['table_prefix'] .'attachment';
			
			$this->delete(array(
				'where' => str_replace('#module_table#', $_system['table_prefix'] .'attachment', $cond),
				'hook' => true
			));
		}
		
		$this->table = $this->core->attachment_table;
		
		//核心表
		$this->delete(array(
			'where' => str_replace('#module_table#', $this->core->attachment_table, $cond),
			'hook' => true
		));
	}else{
		//根据模块从属的不同系统,删除相应的附件表
		$this->table = $obj->system->attachment_table;
		
		$this->delete(array(
			'where' => str_replace('#module_table#', $obj->system->attachment_table, $cond) ." AND module = '$obj->name'",
			'hook' => true
		));
	}
	
	$this->table = $orig_table;
}

/**
* 删除附件
**/
function delete($data){
    
	$query = $this->DB_master->query("SELECT id, path, remote, thumb FROM $this->table WHERE $data[where]");
	/*//不删附件 2015-01-01
	while($arr = $this->DB_master->fetch_array($query)){
		$ftp = null;
		if($arr['remote']){
			$ftp = &$this->ftp($this->CONFIG['ftp_config']);
			$ftp->delete($ftp->dir . $arr['path']);
			//删除缩略图
			$arr['thumb'] ? $ftp->delete($ftp->dir . $arr['path'] .'.thumb.jpg') : '';
			$arr['thumb'] == 2 ? $ftp->delete($ftp->dir . $arr['path'] .'.cthumb.jpg') : '';
		}else{
			@unlink($this->attachment_path . $arr['path']);
			$arr['thumb'] ? @unlink($this->attachment_path . $arr['path'] .'.thumb.jpg') : '';
			$arr['thumb'] == 2 ? @unlink($this->attachment_path . $arr['path'] .'.cthumb.jpg') : '';
		}
	}
	*/
	if($status = $this->DB_master->delete($this->table, $data['where'])){
		
	}
	
	return $status;
}

}