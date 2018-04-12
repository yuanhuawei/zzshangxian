<?php
defined('PHP168_PATH') or die();

//P8_Core::list_plugins($refresh = false)
	$plugins = $this->DB_master->fetch_all("SELECT * FROM {$this->TABLE_}plugin");

	foreach($plugins as $v){
		$this->plugins[$v['name']] = $v;
	}

	$plugins = $_plugins = array();
	$path = $this->path .'plugin/';

	$handle = opendir($path);
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;

		if(is_dir($path . $item) && is_file($path . $item .'/plugin.php') && ($info = @include $path . $item .'/#.php')){
			$enabled = empty($this->plugins[$item]['enabled']) ? false : true;
			$installed = empty($this->plugins[$item]['installed']) ? false : true;
			
			$_plugins[$item] = array(
				'alias' => $info['alias'],	//�������
				'class' => $info['class'],	//�������
				'enabled' => $enabled,
				'installed' => $installed
			);
			//д�����õ�
			
			//���µ�ģ��
			$plugins[$item] = array(
				'name' => $item,			//�������
				'alias' => $info['alias'],	//�������
				'class' => $info['class'],	//�������
				'enabled' => $enabled ? 1 : 0,
				'installed' => $installed ? 1 : 0
			);
			//д���ݿ��õ�
		}
		
		//ע�������ڵĲ��,���û��ע��˵���Ǳ�ɾ����
		unset($this->plugins[$item]);
	}
	closedir($handle);

	//ɾ����ɾ���Ĳ��
	foreach((array)$this->plugins as $k => $v){
		$this->DB_master->delete($this->TABLE_ .'plugin', "name = '$k'");
	}

	$fields = array('name', 'alias', 'class', 'enabled', 'installed');
	$this->DB_master->insert(
		$this->TABLE_ .'plugin',
		$plugins,
		array(
			'multiple' => $fields,
			'replace' => true
		)
	);

	return $this->plugins = $_plugins;