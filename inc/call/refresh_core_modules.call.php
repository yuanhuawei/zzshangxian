<?php
defined('PHP168_PATH') or die();

//P8_Core::list_modules($refresh = false)
	$modules = $this->DB_master->fetch_all("SELECT * FROM {$this->TABLE_}module WHERE system = 'core'");

	foreach($modules as $v){
		$this->modules[$v['name']] = $v;
	}

	$modules = $_modules = array();
	$path = $this->path .'modules/';

	$handle = opendir($path);
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;

		if(is_dir($path . $item) && is_file($path . $item .'/module.php') && ($info = @include $path . $item .'/#.php')){
			$_modules[$item] = array(
				'alias' => $info['alias'],	//ϵͳ����
				'class' => $info['class'],	//ϵͳ����
				'controller_class' => $info['controller_class'],	//ϵͳ����
				'enabled' => empty($this->modules[$item]['enabled']) ? false : true,
				'installed' => empty($this->modules[$item]['installed']) ? false : true
			);
			//д�����õ�
			
			//���µ�ģ��
			$modules[$item] = array(
				'system' => 'core',				//ϵͳ����
				'name' => $item,				//ģ������
				'alias' => $info['alias'],	//ģ�����
				'class' => $info['class'],	//ģ�����
				'controller_class' => $info['controller_class'],
				'enabled' => empty($this->modules[$item]['enabled']) ? 0 : 1,
				'installed' => empty($this->modules[$item]['installed']) ? 0 : 1
			);
			//д���ݿ��õ�
		}
		
		//ע�������ڵ�ģ��,���û��ע��˵���Ǳ�ɾ����
		unset($this->modules[$item]);
	}
	closedir($handle);

	//ɾ����ɾ����ģ��
	foreach((array)$this->modules as $k => $v){
		$this->DB_master->delete($this->TABLE_ .'module', "system = 'core' AND name = '$k'");
	}

	$fields = array('system', 'name', 'alias', 'class', 'controller_class', 'enabled', 'installed');
	$this->DB_master->insert(
		$this->TABLE_ .'module',
		$modules,
		array(
			'multiple' => $fields,
			'replace' => true
		)
	);

	return $this->modules = $_modules;