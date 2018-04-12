<?php
defined('PHP168_PATH') or die();

/**
* 个人主页
**/

$EDIT_HOMEPAGE = $IS_HOST && !empty($_GET['edit']);
$EDIT_HOMEPAGE && $PAGE_CACHE_PARAM['no_cache'] = true;

$PAGE_CACHE_PARAM['ttl'] = empty($core->CONFIG['homepage']['ttl']) ? 0 : $core->CONFIG['homepage']['ttl'];
page_cache($PAGE_CACHE_PARAM);

//访问记录
if($USERNAME && $USERNAME != $_USERNAME){
	$DB_master->insert(
		$core->TABLE_ .'homepage_view',
		array(
			'uid' => $USER['id'],
			'view_uid' => $UID,
			'view_username' => $USERNAME,
			'timestamp' => P8_TIME
		),
		array(
			'replace' => true
		)
	);
}

$BLOCKS = $CACHE->read('', 'core', 'homepage_block');
$BLOCKS = $homepage->format_blocks($BLOCKS,$USER);

//第一次初始化

if(empty($USER['homepage']))
	require PHP168_PATH .'homepage/init.php';
$USER['homepage'] = mb_unserialize($USER['homepage']);
$TITLE = $USER['homepage']['name'];

//已经使用的块
$selected_block = array();

//布局
$LAYOUT = &$USER['homepage']['layout'];
$LEFT = get_block($LAYOUT['left']['block']);
$CENTER = get_block($LAYOUT['center']['block']);
$RIGHT = get_block($LAYOUT['right']['block']);

//编辑
if($EDIT_HOMEPAGE) include PHP168_PATH .'homepage/edit.php';
//exit here

include template($core, 'index');

page_cache();









function get_block($my_block){
	global $core, $selected_block, $BLOCKS;
	
	$ret = array();
	foreach($my_block as $name => $block){
		
		if($BLOCKS[$name]['system'] == 'core'){
			$system = &$core;
		}else
		if($BLOCKS[$name]['system']){
			$system = &$core->load_system($BLOCKS[$name]['system']);
		}else{
		return false;
		}
		
		$module = $system->load_module($BLOCKS[$name]['module']);
		
		$method = 'homepage_'. $BLOCKS[$name]['method'];
		
		$ret[$name] = $module->$method($block);
		
		$selected_block[$name] = $block;
	}
	
	return $ret;
}