<?php
defined('PHP168_PATH') && $IS_HOST or die();

/**
* ±à¼­Ä£¿é
**/

$name = isset($_GET['name']) ? $_GET['name'] : '';
$name or exit('');

$BLOCKS = $CACHE->read('', 'core', 'homepage_block');

$name = isset($_GET['name']) ? $_GET['name'] : '';
$name && isset($BLOCKS[$name]) or exit('');


load_language($core, 'homepage_config');

$block = $BLOCKS[$name];

if($block['system'] == 'core'){
	$system = &$core;
}else{
	$system = &$core->load_system($block['system']);
}

$module = $system->load_module($block['module']);

$HOMEPAGE = mb_unserialize($USER['homepage']);

if(isset($HOMEPAGE['layout']['left']['block'][$name])){
	$data = $HOMEPAGE['layout']['left']['block'][$name];
}else if(isset($HOMEPAGE['layout']['center']['block'][$name])){
	$data = $HOMEPAGE['layout']['center']['block'][$name];
}else if(isset($HOMEPAGE['layout']['right']['block'][$name])){
	$data = $HOMEPAGE['layout']['right']['block'][$name];
}else{
	$data = $block;
}

require $module->path .'homepage/block/'. $block['method'] .'.config.php';
exit;