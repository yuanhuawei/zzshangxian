<?php
defined('PHP168_PATH') or die();

/**
* ³õÊ¼»¯
**/

$menus = array();
foreach($MENU['top_menus'] as $v){
	$menus[] = $v['id'];
}

$USER['homepage'] = array(
	'layout' => array(
		'' => '1:2:1',
		'left' => array(
			'width' => 240,
			'block' => array(
				'core_member_profile' => $BLOCKS['core_member_profile'],
				'core_member_view' => $BLOCKS['core_member_view'],
			)
		),
		
		'center' => array(
			'width' => 470,
			'block' => array(
			)
		),
		
		'right' => array(
			'width' => 240,
			'block' => array(
				'core_member_friend' => $BLOCKS['core_member_friend'],
			)
		)
	),
	'name' => p8lang($P8LANG['homepage_of_somebody'], $USER['username']),
	'banner' => '',
	'seo_keywords' => '',
	'seo_description' => '',
	'menus' => $menus
);

if(($m = get_module('cms', 'item')) && !empty($m['installed'])){
	$USER['homepage']['layout']['center']['block']['cms_item_list'] = $BLOCKS['cms_item_list'];
}

if(($m = get_module('ask', 'item')) && !empty($m['installed'])){
	$USER['homepage']['layout']['center']['block']['ask_item_list'] = $BLOCKS['ask_item_list'];
}


$DB_master->update(
	$core->member_table,
	array(
		'homepage' => $DB_master->escape_string(serialize($USER['homepage']))
	),
	'id = \''. $USER['id'] .'\''
);

get_member($USER['username'], true);