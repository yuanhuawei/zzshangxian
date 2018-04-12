<?php
defined('PHP168_PATH') or die();

/**ÒÆ¶¯Ä£°å**/
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$config = $core->get_config('core', '');
	include template($core, 'template/template_mobile', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$mobile_template = isset($_POST['mobile_template']) ? $_POST['mobile_template'] : '';
	
	$core->set_config(array('mobile_template' => $mobile_template));
	

		$core->set_config(array('mobile_template' => $mobile_template));
		
		foreach($core->modules as $mod => $v){
			if(empty($v['installed'])) continue;
			
			$m = &$core->load_module($mod);
			$m->set_config(array('mobile_template' => $mobile_template));
			
			$core->unload('core', $mod);
		}
		
		
		foreach($core->systems as $sys => $v){
			if(empty($v['installed'])) continue;

			$s = &$core->load_system($sys);
			$s->set_config(array(
				'mobile_template' => $mobile_template
			));
			
			foreach($s->modules as $module => $v){
				if(empty($v['installed'])) continue;
				
				$m = &$s->load_module($module);
				$m->set_config(array('mobile_template' => $mobile_template));
			}
			
			$core->unload($sys);
		}
		

	
	message('done');
	
}

?>