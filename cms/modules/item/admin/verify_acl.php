<?php
defined('PHP168_PATH') or die();

/**
* 多级审核
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$config = $core->get_config($SYSTEM, $MODULE);
	isset($config['verify_acl_max']) || $config['verify_acl_max'] = 0;
	$max = $config['verify_acl_max'];
	
	$config = isset($this_module->CONFIG['verify_acl']) ? $this_module->CONFIG['verify_acl'] : array();
	
	/* if($max == 0){
		$tmp = $config;
		unset($tmp[1], $tmp[0], $tmp[-99]);
		$max = $tmp ? min(array_keys($tmp)) : 0;
	} */
	
	$roles = $core->get_cache('role', 'role_group', $core->CONFIG['administrator_role_group'], 'core', 'system');
	
	$role_json = p8_json($roles);
	$acl_json = p8_json($config);
	
	include template($this_module, 'verify_acl', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_acl = isset($_POST['verify_acl']) && is_array($_POST['verify_acl']) ? $_POST['verify_acl'] : array(); unset($_acl['*']);
	
	$acl = array();
	//值0,1和-99是特殊值
	foreach(array(1, 0, -99) as $status){
		$acl[$status] = array(
			'name' => $P8LANG['cms_item']['verify'][$status],
			'role' => isset($_acl[$status]['role']) ? (array)$_acl[$status]['role'] : array()
		);
		unset($_acl[$status]);
	}
	
	$config = $core->get_config($SYSTEM, $MODULE);
	isset($config['verify_acl_max']) || $config['verify_acl_max'] = 0;
	$max = $config['verify_acl_max'];
	
	$i = -1;
	$_acl = array_reverse($_acl, true);
	foreach($_acl as $k => $v){
		if(!$k = intval($k)) continue;
		
		if($k < $max){
			$max = $k;
		}
		
		$acl[$k] = array(
			'name' => isset($v['name']) ? $v['name'] : '',
			'role' => isset($v['role']) ? (array)$v['role'] : array()
		);
	}
	
	$max = min($max, $config['verify_acl_max']);
	$this_module->set_config(array('verify_acl' => $acl, 'verify_acl_max' => $max));
	
	message('done');
}