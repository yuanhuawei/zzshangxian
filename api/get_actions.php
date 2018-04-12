<?php
/**
* 获得系统或模块的action的json
**/

require dirname(__FILE__) .'/../inc/init.php';


$system = isset($_GET['system']) ? $_GET['system'] : '';
$module = isset($_GET['module']) ? $_GET['module'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'actions';
$callback = isset($_GET['callback']) ? xss_clear($_GET['callback']) : '';
$type_filter = array('actions', 'admin_actions', 'credit_rule_actions');

in_array($type, $type_filter) or exit('{}');


if($system == 'core'){
	if($module && isset($core->modules[$module])){
		$info = @include(PHP168_PATH .'modules/'. $module .'/#.php');
	}else{
		$info = @include(PHP168_PATH .'#.php');
	}
	
}else if(isset($core->systems[$system])){
	if($module && isset($core->CONFIG['system&module'][$system]['modules'][$module])){
		$info = @include(PHP168_PATH . $system .'/modules/'. $module .'/#.php');
	}else{
		$info = @include(PHP168_PATH . $system .'/#.php');
	}
	
}else{
	exit('{}');
}

isset($info[$type]) or exit('{}');

$actions = $info[$type];


$json = array();

exit($callback .'('. jsonencode($actions) .');');