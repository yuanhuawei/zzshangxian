<?php
defined('PHP168_PATH') or die();

/**系统模板**/
$this_controller->check_admin_action('template') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	GetGP(array('system'));
	!$system && $system='core';
	$config = $core->get_config($system, '');
	
	include template($core, 'template/template_system', 'admin');
	
}else{
	
	$template = isset($_POST['template']) ? basename($_POST['template']) : '';
	$system = isset($_POST['system']) ? basename($_POST['system']) : '';
	
	if($system == 'core'){
		
		$core->set_config(array('template' => $template));
		
		foreach($core->modules as $mod => $v){
			//没装的不管
			if(empty($v['installed'])) continue;
			
			$m = &$core->load_module($mod);
			if(!is_dir(TEMPLATE_PATH . $template .'/core/'. $mod))	//没相应模板的设为缺省
			$m->set_config(array('template' => ''));
			else
			$m->set_config(array('template' => $template));
			
			$core->unload('core', $mod);
			
		}
		
		
		foreach($core->systems as $sys => $v){
			//没装的不管
			if(empty($v['installed'])) continue;
			if(!is_dir(TEMPLATE_PATH . $template .'/'. $sys)) continue;
			$s = &$core->load_system($sys);
			$s->set_config(array(
				'template' => $template
			));
			
			foreach($s->modules as $module => $v){
				//没装的不管
				if(empty($v['installed'])) continue;
				
				$m = &$s->load_module($module);
				$m->set_config(array('template' => $template));
			}
			
			$core->unload($sys);
		}
		
	}else{
		
		$s = &$core->load_system($system);
		$s->set_config(array(
			'template' => $template
		));
		
		foreach($s->modules as $module => $v){
			//没装的不管
			if(empty($v['installed'])) continue;
			if(!is_dir(TEMPLATE_PATH . $template .'/'.$system.'/'. $module)) continue;
			$m = &$s->load_module($module);
			$m->set_config(array(
				'template' => $template
			));
		}
	}
	
	message('done',$this_url,3);
	
}

?>