<?php
defined('PHP168_PATH') or die();
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	load_language($core, 'config');
	$json = $this_module->get_json();

	include template($this_module, 'add', 'admin');
}else{
	
			$names = isset($_POST['name']) ? array_filter(array_map('trim', explode("\r\n", $_POST['name']))) : array();
			foreach($names as $name){
				$_POST['name'] = $name;
				$id = $this_controller->add_sort($_POST) or message('fail');
				$ids[$id] = 1;
			}
			
			$this_module->cache(false, true, $ids);
		
		message('done',$this_router.'-list');

}