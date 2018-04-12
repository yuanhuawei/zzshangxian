<?php
defined('PHP168_PATH') or die();

/**
* 导入CMS模型
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$importable_models = array();
	
	$dir = $this_system->path .'#export/';
	$handle = opendir($dir);
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..' || !is_file($dir . $item .'/#data.php')) continue;
		
		$importable_models[] = $item;
	}
	
	include template($this_module, 'import', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	@set_time_limit(0);
	
	$name = isset($_POST['name']) ? basename($_POST['name']) : '';
	is_dir($this_system->path .'#export/'. $name) or message('no_such_cms_model');
	
	$alias = isset($_POST['alias']) ? html_entities($_POST['alias']) : '';
	
	$this_module->import($name, $alias) or message('fail');
	
	//表分区计划任务
	if(!empty($this_system->CONFIG['model_partition_crontab'])){
		$crontab_id = $this_system->CONFIG['model_partition_crontab'];
		
		$crontab = &$core->load_module('crontab');
		include $crontab->path .'inc/run.php';
	}
	
	message('done');
}