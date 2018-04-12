<?php
/**
*»áÔ±Ñ¡Ôñ
**/
defined('PHP168_PATH') or die();
$core->get_cache('role_group');
$core->get_cache('role');
$status_json = array();
foreach($this_module->status as $status => $lang){
	$status_json[$status] = $P8LANG['member_status'][$lang];
}
$status_json = p8_json($status_json);
$role_group_json = p8_json($core->role_groups);
$role_json = p8_json($core->roles);
include template($this_module, 'selectuser');