<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'GET'){
	
	load_language($this_plugin, 'global');	//¼ÓÔØÓïÑÔ°ü
	
	$config = $this_plugin->get_config(false);
	$config['enabled'] = $core->plugins['contact']['enabled'];
	include $this_plugin->template('config');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$this_plugin->set_config($config);
	
	message('done', $_this_url);
}
