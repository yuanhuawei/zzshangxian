<?php
defined('PHP168_PATH') or die();

//P8_System::list_modules($refresh = false)
	$modules = $this->DB_master->fetch_all("SELECT * FROM {$this->core->TABLE_}module WHERE system = '$this->name'");
	
	foreach($modules as $v){
		$this->modules[$v['name']] = $v;
	}
	
	$modules = $_modules = array();
	
	$path = $this->path .'modules/';
	$handle = opendir($path);
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;
		
		if(is_dir($path . $item) && is_file($path . $item .'/module.php') && ($info = include $path . $item .'/#.php')){
			$_modules[$item] = array(
				'alias' => $info['alias'],	//ϵͳ����
				'class' => $info['class'],	//ϵͳ����
				'controller_class' => $info['controller_class'],
				'enabled' => empty($this->modules[$item]['enabled']) ? false : true,
				'installed' => empty($this->modules[$item]['installed']) ? false : true
				//�Ƿ�װ��
			
			);
			//д�����õ�
			
			//if(empty($this->modules[$item])){
				//���µ�ģ��
				$modules[$item] = array(
					'system' => $this->name,				//ϵͳ����
					'name' => $item,		//ģ�����
					'alias' => $info['alias'],	//ģ�����
					'class' => $info['class'],	//ģ�����
					'controller_class' => $info['controller_class'],	//ϵͳ����
					'enabled' => empty($this->modules[$item]['enabled']) ? 0 : 1,				//�Ƿ����
					'installed' => empty($this->modules[$item]['installed']) ? 0 : 1				//�Ƿ�װ��
				);
				//д���ݿ��õ�
			//}
			
			unset($this->modules[$item]);
		}
	}
	closedir($handle);
	
	//ɾ����ɾ����ģ��
	foreach((array)$this->modules as $k => $v){
		$this->DB_master->delete($this->core->TABLE_ .'module', "system = '$this->name' AND name = '$k'");
	}
	
	//�����ģ��
	$fields = array('system', 'name', 'alias', 'class', 'controller_class', 'enabled', 'installed');
	$this->DB_master->insert(
		$this->core->TABLE_ .'module',
		$modules,
		array(
			'multiple' => $fields,
			'replace' => true
		)
	);
	
	//global $CACHE;
	//$CACHE->write('', $this->name, 'modules', $_modules);
	
	return $this->modules = $_modules;