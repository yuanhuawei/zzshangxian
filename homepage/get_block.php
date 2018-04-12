<?php
defined('PHP168_PATH') && $IS_HOST or die();

/**
* »ñÈ¡Çø¿é
**/

$_BLOCKS = $DB_master->fetch_all("SELECT * FROM {$core->TABLE_}homepage_block");
$BLOCKS = array();
foreach($_BLOCKS as $k => $v){
	$BLOCKS[$v['name']] = $v;
}

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

$method = 'homepage_'. $block['method'];

$data = $module->$method($block);

exit($data);