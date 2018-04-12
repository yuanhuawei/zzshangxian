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
* ���õ�ǰģ��ʹ���ĸ�ϵͳ��
* @param string $system ϵͳ����,���Ϊ��ʹ�ú���
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
* ģ������,��������μ�core
* ftp_config Ϊ�����ֶ�
**/
/* function set_config(
	$datas, 
	$protect_fields = array(	//FTP���ÿ��Ը��ݲ�ͬ��վ���ò�ͬ��FTP
		//'ftp_config' => 1
	),
	$ignore_fields = array(
		'_filter' => 1
	)
){
	parent::set_config($datas, $protect_fields, $ignore_fields);
} */

/**
* ����FTP���������
* @param array $config FTP������
* @return object FTP����
**/
function &ftp($config){
	require_once PHP168_PATH .'inc/ftp.class.php';
	
	//��host:port/dir���ַ�ʽ�洢�����±�
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
* �ϴ��ļ�
**/
function upload($data){
	
	global $UID;
	
	list($year, $month, $day, $hour) = explode('|', date('Y|m|d|H', P8_TIME));
	$path = $this->_system .'/'. ($this->_module ? $this->_module .'/' : '') .
		$year .'_'. $month .'/'. $day .'_'. $hour;
	
	$func = empty($data['capture']) ? 'move_uploaded_file' : 'rename';
	
	$ftp = null;
	//Զ�̸���
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
		//Ψһ���ļ�
		$upload_file = $path .'/'. unique_id(16) .'.'. $v['ext'];
		$thumb = 0;
		
		$_ext = strtolower($v['ext']);
		
		if(
			!empty($this->CONFIG['thumb']['enabled']) || !empty($this->CONFIG['watermark']['enabled'])
		){
			
			//��������ͼ��ˮӡ
			
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
				
				//��������ͼ,����Ǽ���ͼƬ��ȡ��
				if(
					!empty($this->CONFIG['thumb']['enabled']) &&
					image_thumb(
						$v['tmp_name'], $thumb_file = $v['tmp_name'] .'.thumb.jpg',
						$thumb_width, $thumb_height, true,
						$this->CONFIG['thumb']['quality']
					)
				){
					
					//�ɹ���������ͼ
					if($ftp){
						//������ͼҲ����FTP��
						$ftp->put($thumb_file, $ftp->dir . $upload_file .'.thumb.jpg');
						$ftp->chmod($ftp->dir . $upload_file .'.thumb.jpg', 0644);
					}else{
						//������ͼ�ϴ�
						rename($thumb_file, $this->attachment_path . $upload_file .'.thumb.jpg');
						@chmod($this->attachment_path . $upload_file .'.thumb.jpg', 0644);
					}
					$thumb = 1;
					@unlink($thumb_file);
					
					//����ҳ����ͼ
					if(
						image_thumb(
							$v['tmp_name'], $thumb_file = $v['tmp_name'] .'.cthumb.jpg',
							$cthumb_width, $cthumb_height, true,
							$this->CONFIG['thumb']['quality']
						)
					){
						//����ҳ����ͼˮӡ
						$watermark &&
						image_watermark(
							$thumb_file, $thumb_file,
							PHP168_PATH . $this->CONFIG['watermark']['file'],
							$this->CONFIG['watermark']['position'],
							$this->CONFIG['watermark']['quality']
						);
						
						//�ɹ���������ͼ
						if($ftp){
							//������ͼҲ����FTP��
							$ftp->put($thumb_file, $ftp->dir . $upload_file .'.cthumb.jpg');
							$ftp->chmod($ftp->dir . $upload_file .'.cthumb.jpg', 0644);
						}else{
							//������ͼ�ϴ�
							rename($thumb_file, $this->attachment_path . $upload_file .'.cthumb.jpg');
							@chmod($this->attachment_path . $upload_file .'.cthumb.jpg', 0644);
						}
						$thumb = 2;
						@unlink($thumb_file);
					}
				}
				
				//ˮӡ
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
		
		//�ϴ�(ftp)
		if($ftp){
			$status = $ftp->put($v['tmp_name'], $ftp->dir . $upload_file);
			$ftp->chmod($ftp->dir . $upload_file, 0644);
		}else{
			$status = $func($v['tmp_name'], $this->attachment_path . $upload_file);
			@chmod($this->attachment_path . $upload_file, 0644);
		}
		
		@unlink($v['tmp_name']);
		
		$system_info = get_system($this->_system);
		
		//���޸��ļ�����
		$v['alias'] = isset($v['alias']) ? $v['alias'] : $v['name'];
		
		//�������ݿ�
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
* ����ģ��ɾ��,ʵ��ɾ����������
* @param object $obj ģ�����
* @param string $cond ����
**/
function hook_delete(&$obj, $cond){
	
	$orig_table = $this->table;
	
	if($obj->system->name == 'core' && $obj->name == 'member'){
		//�ӻ�Աģ�鴫�ݹ�����,ɾ������ϵͳ�����и���
		
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
		
		//���ı�
		$this->delete(array(
			'where' => str_replace('#module_table#', $this->core->attachment_table, $cond),
			'hook' => true
		));
	}else{
		//����ģ������Ĳ�ͬϵͳ,ɾ����Ӧ�ĸ�����
		$this->table = $obj->system->attachment_table;
		
		$this->delete(array(
			'where' => str_replace('#module_table#', $obj->system->attachment_table, $cond) ." AND module = '$obj->name'",
			'hook' => true
		));
	}
	
	$this->table = $orig_table;
}

/**
* ɾ������
**/
function delete($data){
    
	$query = $this->DB_master->query("SELECT id, path, remote, thumb FROM $this->table WHERE $data[where]");
	/*//��ɾ���� 2015-01-01
	while($arr = $this->DB_master->fetch_array($query)){
		$ftp = null;
		if($arr['remote']){
			$ftp = &$this->ftp($this->CONFIG['ftp_config']);
			$ftp->delete($ftp->dir . $arr['path']);
			//ɾ������ͼ
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