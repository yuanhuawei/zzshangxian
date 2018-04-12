<?php
/**
* 获得模块的JSON
**/

require dirname(__FILE__) .'/../inc/init.php';


$system = isset($_GET['system']) ? $_GET['system'] : '';
$callback = isset($_GET['callback']) ? $_GET['callback'] : '';

$modules = null;

if($system == 'core'){
	$modules = &$core->CONFIG['modules'];
}else{
	isset($core->CONFIG['system&module'][$system]) or exit('[]');
	
	$modules = &$core->CONFIG['system&module'][$system]['modules'];
}

$json = array();
foreach($modules as $k => $v){
	$json[] = array(
		'name' => $k,
		'alias' => $v['alias'],
		'url' => $v['url'],
	);
}

exit($callback .'('. jsonencode($json) .');');