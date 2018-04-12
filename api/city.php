<?php
require dirname(__FILE__) .'/../inc/init.php';

require_once PHP168_PATH .'inc/area.class.php';
$area = new P8_Area();
$area->get_cache();

$callback = isset($_GET['callback']) ? xss_clear($_GET['callback']) : '';
$json = '{}';

if(isset($_GET['parent'])){
	$parent = intval($_GET['parent']);
	
	if(isset($area->areas[$parent]['areas']) || $parent == 0){
		$ret = array();
		if(isset($area->areas[$parent]['areas'])){
			$for = $area->areas[$parent]['areas'];
		}else{
			$for = $area->province;
		}
		
		foreach($for as $v){
			isset($v['areas']) && $v['areas'] = true;
			$ret[$v['id']] = $v;
		}
		
		$json = jsonencode($ret);
	}else{
		$json = '{}';
	}
	
}else if(isset($_GET['id'])){
	
	/*
	array(
		''
	)
	*/
	$ret = array();
	foreach((array)$_GET['id'] as $id){
		if(isset($area->areas[$id])){
			$ret[$id] = $area->areas[$id];
			if(isset($ret[$id]['areas'])) $ret[$id]['areas'] = true;
			
			$ret[$id]['parents'] = array_merge($area->get_parents($id), array($ret[$id]));
			
			foreach($ret[$id]['parents'] as $parent_cat){
				$tmp = $parent_cat['parent'] == 0 ? $area->province : $area->areas[$parent_cat['parent']]['areas'];
				
				foreach($tmp as $sub_cat){
					isset($sub_cat['areas']) && $sub_cat['areas'] = true;
					$ret[$id]['paths'][$parent_cat['parent']][$sub_cat['id']] = $sub_cat;
				}
			}
		}
		
	}
	//print_R($ret);
	$json = jsonencode($ret);
}

exit($callback .'('. $json .');');