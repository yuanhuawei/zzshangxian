<?php
defined('PHP168_PATH') or die();

/**
* 积分规则列表
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$system = isset($_GET['system']) ? $_GET['system'] : 'core';
$module = isset($_GET['module']) ? $_GET['module'] : '';
$postfix = isset($_GET['postfix']) ? preg_replace('/[^0-9a-zA-z_]/', '', $_GET['postfix']) : '';
$all = empty($_GET['all']) ? 0 : 1;

if($system != 'core' && !isset($core->systems[$system])){
	message('no_such_system');
}

$systems = $core->systems;
$modules = get_modules($system);



if($system == 'core'){
	if($module == ''){
		$info = include PHP168_PATH .'/#.php';
	}else{
		$info = include PHP168_PATH .'modules/'. $module .'/#.php';
	}
}else{
	if($module == ''){
		$info = include PHP168_PATH . $system .'/#.php';
	}else{
		$info = include PHP168_PATH . $system .'/modules/'. $module .'/#.php';
	}
}

$core->get_cache('role');

load_language($core, 'config');

if(empty($info['credit_rule_actions'])){
	$list = array();
}else{
	$select = select();
	$select->from($this_module->rule_table, '*');
	$select->in('system', $system);
	$select->in('module', $module);
	if(!$all)
		$select->in('postfix', $postfix);
	$select->order('action ASC');

	$list = $core->list_item($select);
	
	$core->get_cache('credit');
	
	foreach($list as $k => $v){
		$list[$k]['action'] = $info['credit_rule_actions'][$v['action']];
		$list[$k]['credit_id'] = $core->credits[$v['credit_id']]['name'];
	}
	
}



include template($this_module, 'list_rule', 'admin');