<?php
defined('PHP168_PATH') or die();

//P8_System::list_systems($refresh = false)
	$systems = $this->DB_master->fetch_all("SELECT * FROM {$this->TABLE_}system");
	//读数据库里的记录
	
	foreach($systems as $v){
		$this->systems[$v['name']] = $v;
	}
	
	$systems = $_systems = array();
	$handle = opendir(PHP168_PATH);
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;
		
		//文件夹下面有同名php文件,并且有配置文件的将会被认为是一个系统如b, b/system.php, b/#.php
		if(is_dir(PHP168_PATH . $item) && is_file(PHP168_PATH . $item .'/system.php') && ($info = @include PHP168_PATH . $item .'/#.php')){
			$_systems[$item] = array(
				'alias' => $info['alias'],	//系统别名
				'class' => $info['class'],	//系统的类
				'controller_class' => $info['controller_class'],	//系统的类
				'table_prefix' => empty($this->systems[$item]['table_prefix']) ? '' : $this->systems[$item]['table_prefix'],
				'enabled' => empty($this->systems[$item]['enabled']) ? false : true,				//是否可用
				'installed' => empty($this->systems[$item]['installed']) ? false : true
				//是否安装过
			);
			//写缓存用的
			
			//有新的系统
			$systems[$item] = array(
				'name' => $item,
				'alias' => $info['alias'],	//系统别名
				'table_prefix' => empty($this->systems[$item]['table_prefix']) ? '' : $this->systems[$item]['table_prefix'],	//表前缀
				'class' => $info['class'],	//系统的类
				'controller_class' => $info['controller_class'],	//系统的类
				'enabled' => empty($this->systems[$item]['enabled']) ? 0 : 1,				//是否可用
				'installed' => empty($this->systems[$item]['installed']) ? 0 : 1
				//是否安装过
			);
			//写数据库用的
			
			unset($this->systems[$item]);
		}
	}
	closedir($handle);
	
	//删除己删除的系统
	foreach((array)$this->systems as $k => $v){
		$this->DB_master->delete($this->TABLE_ .'system', "name = '$k'");
	}
	
	//插入的字段
	$fields = array('name', 'alias', 'table_prefix', 'class', 'controller_class', 'enabled', 'installed');
	//以replace into的方式插入
	$this->DB_master->insert(
		$this->TABLE_ .'system',
		$systems,
		array(
			'multiple' => $fields,
			'replace' => true
		)
	);
	
	return $this->systems = $_systems;