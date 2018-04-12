<?php 
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

P8_AJAX_REQUEST or die();

if(REQUEST_METHOD == 'POST'){
	
	$this_module->get_cache();
	$json = array();
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$level = isset($_POST['level']) ? intval($_POST['level']) : 0;
	$level = max(0, $level);
	
	if($id){
		$json = !empty($this_module->categories[$id]['categories']) ? $this_module->categories[$id]['categories'] : '';
	}else{
		$json = $this_module->top_categories;
	}
	
	if($level && $json){
		foreach($json as $k => $v){
			if(isset($v['categories'])){
				$json[$k]['categories'] = true;
			}
		}
	}
	
	echo jsonencode($json);
	
}
exit;