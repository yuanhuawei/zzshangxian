<?php
defined('PHP168_PATH') or die();

$IS_ADMIN or message('no_privilege');

require_once PHP168_PATH .'/modules/member/inc/menu.class.php';


$member_menu->get_cache();
$denied = $IS_FOUNDER ? array() : $CACHE->read('', 'core', 'admin_menu_role_'. $core->ROLE);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
//菜单级数
$level = isset($_GET['level']) ? intval($_GET['level']) : 0;
$level = max(0, $level);

foreach($denied as $k => $v){
	$member_menu->menus[$k] = null;
	unset($member_menu->menus[$k]);
}
//print_r($member_menu->menus);
if($id){
	$json = isset($member_menu->menus[$id]['menus']) ? $member_menu->menus[$id]['menus'] : array();
}else{
	$json = &$member_menu->top_menus;
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