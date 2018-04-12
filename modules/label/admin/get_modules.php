<?php
defined('PHP168_PATH') or die();

$IS_ADMIN or exit('[]');

$system = isset($_GET['system']) ? $_GET['system'] : '';

$modules = null;

if($system == 'core'){
	$modules = &$core->CONFIG['core&module']['modules'];
	$path = PHP168_PATH .'modules/';
}else{
	isset($core->CONFIG['system&module'][$system]) or exit('[]');
	
	$modules = &$core->CONFIG['system&module'][$system]['modules'];
	
	$path = PHP168_PATH . $system .'/modules/';
}

$json = array();
foreach($modules as $k => $v){
	
	if(!is_file($path . $k .'/admin/label.php')) continue;
	
	$json[] = array(
		'name' => $k,
		'alias' => $v['alias']
	);
}

exit(jsonencode($json));