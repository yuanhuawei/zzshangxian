<?php
defined('PHP168_PATH') or die();

/**
* 添加模型内容入口文件
**/

$this_controller->check_action($ACTION) or message('no_privilege');
$mid = isset($_REQUEST['mid'])? intval($_REQUEST['mid']) : '';
if($mid){
	
	$model = $this_module->get_model($mid,true);
	$model or message('no_such_form');
	$model['enabled'] or message('forms_disabled');
	$this_module->set_model($mid);
	echo '<script>';
	echo "window.open($this_module->controller-post?mid=$mid)";
	echo '</script>';
	
}else{
		$my_addible_forms = $this_controller->get_acl('my_forms_post');
		$models = $this_module->core->CACHE->read('core/modules', 'forms', 'models');
		if(!isset($my_addible_forms[0]) && !$IS_FOUNDER){
			foreach($models as $mname => $mdata){
				if(!array_key_exists($mdata['id'],$my_addible_forms))
				unset($models[$mname]);
			}
		}
		include template($this_module, 'selectforms');
	exit;
}