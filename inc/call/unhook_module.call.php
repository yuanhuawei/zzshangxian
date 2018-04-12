<?php
defined('PHP168_PATH') or die();

//P8_Core::unhook($system, $module)
	$config = $this->core->get_config($system, '');
	
	if(empty($config['hook_modules'][$module][$this->system->name][$this->name])) return false;
	
	$this->system->CONFIG['_hook_modules'] = empty($this->system->CONFIG['_hook_modules']) ? array() : $this->system->CONFIG['_hook_modules'];
	
	unset($this->system->CONFIG['_hook_modules'][$this->name][$system][$module]);
	if(empty($this->system->CONFIG['_hook_modules'][$this->name][$system]))
		unset($this->system->CONFIG['_hook_modules'][$this->name][$system]);
	
	$this->system->set_config(array(
		'_hook_modules' => $this->system->CONFIG['_hook_modules']
	));
	
	unset($config['hook_modules'][$module][$this->system->name][$this->name]);
	
	if($system == 'core'){
		$s = &$this->core;
	}else{
		$s = &$this->core->load_system($system);
	}
	
	$s->set_config(array('hook_modules' => $config['hook_modules']));