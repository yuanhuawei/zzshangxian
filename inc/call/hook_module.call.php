<?php
defined('PHP168_PATH') or die();

//P8_Module::hook($system, $module, $id_field)
	$this->unhook($system, $module);
	
	$config = $this->core->get_config($system, '');
	
	$hook = array();
	
	if(empty($config['hook_modules'])){
		$hook = array();
	}else{
		$hook = $config['hook_modules'];
	}
	
	$hook[$module][$this->system->name][$this->name] = $id_field;
	
	if($system == 'core'){
		$s = &$this->core;
	}else{
		$s = &$this->core->load_system($system);
	}
	
	$this->system->CONFIG['_hook_modules'] = empty($this->system->CONFIG['_hook_modules']) ? array() : $this->system->CONFIG['_hook_modules'];
	$this->system->CONFIG['_hook_modules'][$this->name][$system][$module] = $id_field;
	
	$this->system->set_config(array(
		'_hook_modules' => $this->system->CONFIG['_hook_modules']
	));
	
	return $s->set_config(array('hook_modules' => $hook));