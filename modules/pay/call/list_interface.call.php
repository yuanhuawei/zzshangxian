<?php
defined('PHP168_PATH') or die();

//P8_Pay::list_interface($refresh = true)
	$query = $this->DB_master->query("SELECT * FROM $this->interface_table");
	$this->interfaces = array();
	$interfaces = $_interface = array();
	while($arr = $this->DB_master->fetch_array($query)){
		
		$this->interfaces[$arr['name']] = array(
			'alias' => $arr['alias'],
			'logo' => $arr['logo'],
			'enabled' => $arr['enabled'],
			'config' => mb_unserialize($arr['config'])
		);
	}
	
	$handle = opendir($this->path .'interface/');
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;
		
		if(
			is_dir($this->path .'interface/'. $item) && is_file($this->path .'interface/'. $item .'/interface.php') &&
			($info = @include $this->path .'interface/'. $item .'/#.php')
		){
			//找到符合标准的接口
			
			$_interfaces[$item] = array(
				'alias' => $info['alias'],
				'logo' => $info['logo'],
				'enabled' => empty($this->interfaces[$item]['enabled']) ? 0 : 1,
				'config' => empty($this->interfaces[$item]['config']) ? array() : $this->interfaces[$item]['config']
			);
			//写配置用的
			
			$interfaces[$item] = array(
				'name' => $item,
				'alias' => $info['alias'],
				'logo' => $info['logo'],
				'enabled' => empty($this->interfaces[$item]['enabled']) ? 0 : 1,
				'config' => $this->DB_master->escape_string(serialize(empty($this->interfaces[$item]['config']) ? array() : $this->interfaces[$item]['config']))
			);
			//写数据用的
			
		}
		
		//注销不用删除的接口,剩下的接口都是需要删除的
		unset($this->interfaces[$item]);
	}
	
	$this->set_config(array('interfaces' => $_interfaces));
	
	foreach($this->interfaces as $k => $v){
		$this->DB_master->delete(
			$this->interface_table,
			"name = '$k'"
		);
	}
	
	//批量replace into
	$this->DB_master->insert(
		$this->interface_table,
		$interfaces,
		array(
			'multiple' => array('name', 'alias', 'logo', 'enabled', 'config'),
			'replace' => true
		)
	);
	
	$this->interfaces = $_interfaces;
	
	return $interfaces;