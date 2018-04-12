<?php
defined('PHP168_PATH') or die();

/**
* Ìí¼ÓÄ£ÐÍ
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');
	$models = $this_system->get_models();
	foreach($models as $mo=>$md){
		if(!is_dir($this_system->path .'#export/'. $mo)){
			unset($models[$mo]);
		}
	}
	include template($this_module, 'edit_model', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->add($_POST) or message('fail');
	
	if(!empty($this_system->CONFIG['model_partition_crontab'])){
		$crontab_id = $this_system->CONFIG['model_partition_crontab'];
		
		$crontab = &$core->load_module('crontab');
		include $crontab->path .'inc/run.php';
	}
	
	message('done');
}