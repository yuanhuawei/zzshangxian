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
				'alias' => $info['alias'],	//系统别名
				'class' => $info['class'],	//系统的类
				'controller_class' => $info['controller_class'],	//系统的类
				'enabled' => empty($this->modules[$item]['enabled']) ? false : true,
				'installed' => empty($this->modules[$item]['installed']) ? false : true
			);
			//写缓存用的
			
			//有新的模块
			$modules[$item] = array(
				'system' => 'core',				//系统名称
				'name' => $item,				//模块名称
				'alias' => $info['alias'],	//模块别名
				'class' => $info['class'],	//模块的类
				'controller_class' => $info['controller_class'],
				'enabled' => empty($this->modules[$item]['enabled']) ? 0 : 1,
				'installed' => empty($this->modules[$item]['installed']) ? 0 : 1
			);
			//写数据库用的
		}
		
		//注销己存在的模块,如果没被注销说明是被删除的
		unset($this->modules[$item]);
	}
	closedir($handle);

	//删除己删除的模块
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