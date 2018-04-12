<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$config = $core->get_config($this_system->name, $this_module->name);
	
	$info = include $this_module->path. '#.php';
	load_language($core, 'config');
	
	include template($this_module, 'config', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$orig_htmlize = $this_module->CONFIG['htmlize'];
	
	//如果开启或关闭静态化,应用到所有分类
	if(
		isset($config['htmlize']) && !empty($_POST['htmlize_apply_category']) &&
		$orig_htmlize != $config['htmlize']
	){
		$htmlize = intval($config['htmlize']);
		$category = &$this_system->load_module('category');
		$DB_master->update(
			$category->table,
			array('htmlize' => $htmlize),
			''
		);
		//更新分类的缓存
		$category->cache();
	}
	
	//这两个参数很危险,会放到eval
	if(!empty($config['dynamic_list_url_rule'])) $config['dynamic_list_url_rule'] = html_entities($config['dynamic_list_url_rule']);
	if(!empty($config['dynamic_view_url_rule'])) $config['dynamic_view_url_rule'] = html_entities($config['dynamic_view_url_rule']);
	//这两个参数很危险,会放到eval
	
	$this_module->set_config($config);
	
	message('done');
}