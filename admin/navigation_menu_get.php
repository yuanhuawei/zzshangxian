<?php
defined('PHP168_PATH') or die();
/**
* 为AJAX提供导航菜单下级选择
**/
$IS_ADMIN or message('no_privilege');

require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';
$navigation_menu->get_cache();
$denied = $IS_FOUNDER ? array() : $CACHE->read('', 'core', 'navigation_menu_role_'. $core->ROLE);
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
//菜单级数
$level = isset($_GET['level']) ? intval($_GET['level']) : 0;
$level = max(0, $level);
foreach($denied as $k => $v){
	$navigation_menu->menus[$k] = null;
	unset($navigation_menu->menus[$k]);
}
//print_r($member_menu->menus);
if($id){
	$json = isset($navigation_menu->menus[$id]['menus']) ? $navigation_menu->menus[$id]['menus'] : array();
}else{
	$json = &$navigation_menu->top_menus;
}
if($level){	
	function unsets(&$ms, $level, $l = 1){		
		foreach($ms as $k => $v){
			//达到级数
			if($level == $l){
				if(isset($v['menus'])){
					//删除子菜单
					$ms[$k]['menus'] = null;
				}
				//返回
				continue;
			}			
			if(isset($v['menus']))
				unsets($ms[$k]['menus'], $level, $l+1);
		}
	}
	unsets($json, $level);
}
header('Content-type: text/json; charset=utf-8');
exit(jsonencode($json));