<?php
defined('PHP168_PATH') or die();

$UID or die('[]');

require_once $this_module->path .'inc/menu.class.php';


$member_menu->get_cache();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$level = isset($_GET['level']) ? intval($_GET['level']) : 0;
$level = max(0, $level);

if($id){
	$json = isset($member_menu->menus[$id]['menus']) ? $member_menu->menus[$id]['menus'] : array();
}else{
	$json = &$member_menu->top_menus;
}

if($level){
	
	function unsets(&$ms, $level, $l = 1){
		
		foreach($ms as $k => $v){
			if($level == $l){
				if(isset($v['menus'])){
					$ms[$k]['menus'] = null;
				}
				continue;
			}
			
			if(isset($v['menus']))
				unsets($ms[$k]['menus'], $level, $l+1);
		}
	}
	unsets($json, $level);
}

//header('Content-type: text/json; charset=utf-8');
exit(jsonencode($json));