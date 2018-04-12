<?php
defined('PHP168_PATH') or die();

/**
* ·ÖÀàµÄJSON
**/

$this_module->get_cache();
$callback = isset($_GET['callback']) ? $_GET['callback'] : '';
$json = '{}';

if(isset($_GET['parent'])){
	
	$parent = intval($_GET['parent']);
	
	if(isset($this_module->categories[$parent]['categories']) || $parent == 0){
		$ret = array();
		if(isset($this_module->categories[$parent]['categories'])){
			$for = &$this_module->categories[$parent]['categories'];
		}else{
			$for = &$this_module->top_categories;
		}
		
		foreach($for as $v){
			unset($v['url'], $v['allow_dynamic']);
			isset($v['categories']) && $v['categories'] = true;
			$ret[$v['id']] = $v;
		}
		
		$json = jsonencode($this_module->make_json_sort($ret));
	}else{
		$json = '{}';
	}
	
}else if(isset($_GET['id'])){
	
	$ret = array();
	foreach((array)$_GET['id'] as $id){
		if(isset($this_module->categories[$id])){
			$ret[$id] = $this_module->categories[$id];
			if(isset($ret[$id]['categories'])) $ret[$id]['categories'] = true;
			unset($ret[$id]['url'], $ret[$id]['allow_dynamic']);
			
			$ret[$id]['parents'] = array_merge($this_module->get_parents($id), array($ret[$id]));
			
			foreach($ret[$id]['parents'] as $parent_cat){
				$parent_id = $parent_cat['parent'];
				$tmp = $parent_id == 0 ? $this_module->top_categories : $this_module->categories[$parent_id]['categories'];
				
				foreach($tmp as $sub_cat){
					isset($sub_cat['categories']) && $sub_cat['categories'] = true;
					unset($sub_cat['url'], $sub_cat['allow_dynamic']);
					$ret[$id]['paths'][$parent_id][$sub_cat['id']] = $sub_cat;
				}
			}
		}
		
	}
	//print_R($ret);
	$json = jsonencode($ret);
	
}

exit($callback .'('. $json .');');