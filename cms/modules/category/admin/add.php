<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$MODEL = '';
	$data['model'] = isset($_GET['model']) ? $_GET['model'] : '';
	$data['parent'] = isset($_GET['parent']) ? $_GET['parent'] : 0;
	$data['type']=isset($_GET['type']) ? $_GET['type'] : 2;
	load_language($core, 'config');
	
	$models = $this_system->get_models(true);
	$core->get_cache('role');
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){

	$names = isset($_POST['name']) ? array_filter(array_map('trim', explode("\r\n", $_POST['name']))) : array();
	if(!empty($names)){
		//ÅúÁ¿Ìí¼Ó
		$ids = array();
		ksort($names);
		foreach($names as $name){
			$_POST['name'] = $name;
			$id = $this_controller->add($_POST) or message('fail');
			$ids[$id] = 1;
		}
		
		$this_module->cache(false, true, $ids);
	}

	if(P8_AJAX_REQUEST){
		exit('<script type="text/javascript">document.domain = \''. $core->CONFIG['base_domain'] .'\';parent.edit_dialog.close();parent.ajaxing({action: \'hide\'});</script>');
	}else{
		message('done', $this_url);
	}
}