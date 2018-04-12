<?php
defined('PHP168_PATH') or die();

/**系统模板**/
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$config = $core->get_config('core', '');
	include template($core, 'template/template_user_center', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$member_template = isset($_POST['member_template']) ? $_POST['member_template'] : '';
	
	$core->set_config(array('member_template' => $member_template));
	
	if($system == 'core'){
		
		$core->set_config(array('member_template' => $member_template));
		
		foreach($core->modules as $mod => $v){
			//没装的不管
			if(empty($v['installed'])) continue;
			
			$m = &$core->load_module($mod);
			$m->set_config(array('member_template' => $member_template));
			
			$core->unload('core', $mod);
		}
		
		
		foreach($core->systems as $sys => $v){
			//没装的不管
			if(empty($v['installed'])) continue;
			
			$s = &$core->load_system($sys);
			$s->set_config(array(
				array('member_template' => $member_template)
			));
			
			foreach($s->modules as $module => $v){
				//没装的不管
				if(empty($v['installed'])) continue;
				
				$m = &$s->load_module($module);
				$m->set_config(array('member_template' => $member_template));
			}
			
			$core->unload($sys);
		}
		
	}else{
		
		$s = &$core->load_system($system);
		$s->set_config(array(
			array('member_template' => $member_template)
		));
		
		foreach($s->modules as $module => $v){
			//没装的不管
			if(empty($v['installed'])) continue;
			
			$m = &$s->load_module($module);
			$m->set_config(array(
				array('member_template' => $member_template)
			));
		}
	}
	
	message('done');
	
}

?>