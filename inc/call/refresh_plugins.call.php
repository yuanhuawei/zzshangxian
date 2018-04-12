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
				'alias' => $info['alias'],	//插件别名
				'class' => $info['class'],	//插件的类
				'enabled' => $enabled,
				'installed' => $installed
			);
			//写缓存用的
			
			//有新的模块
			$plugins[$item] = array(
				'name' => $item,			//插件名称
				'alias' => $info['alias'],	//插件别名
				'class' => $info['class'],	//插件的类
				'enabled' => $enabled ? 1 : 0,
				'installed' => $installed ? 1 : 0
			);
			//写数据库用的
		}
		
		//注销己存在的插件,如果没被注销说明是被删除的
		unset($this->plugins[$item]);
	}
	closedir($handle);

	//删除己删除的插件
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