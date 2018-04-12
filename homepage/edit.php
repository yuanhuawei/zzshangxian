<?php
defined('PHP168_PATH') && $IS_HOST or die();

load_language($core, 'homepage_config');

//可选的布局
$LAYOUTS = array(
	'1:2:1' => array(
		'left' => 240,
		'center' => 470,
		'right' => 240
	),
	
	'3:1' => array(
		'left' => 710,
		'center' => 240,
		'right' => 0
	),
	
	'1:3' => array(
		'left' => 240,
		'center' => 710,
		'right' => 0
	),
	
	'1:1' => array(
		'left' => 475,
		'center' => 475,
		'right' => 0
	)
	
	//更多布局自己添加
);

























/**
* 保存配置
**/
if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2(from_utf8($_POST));
	
	$left = isset($_POST['left']) ? (array)$_POST['left'] : array();
	$center = isset($_POST['center']) ? (array)$_POST['center'] : array();
	$right = isset($_POST['right']) ? (array)$_POST['right'] : array();
	$layout = isset($_POST['layout']) ? $_POST['layout'] : '';
	$blocks = isset($_POST['block']) ? (array)$_POST['block'] : array();
	$name = isset($_POST['name']) ? filter_word(html_entities($_POST['name'])) : '';
	$banner = isset($_POST['banner']) ? html_entities($_POST['banner']) : '';
	$seo_keywords = isset($_POST['seo_keywords']) ? filter_word(html_entities($_POST['seo_keywords'])) : '';
	$seo_description = isset($_POST['seo_description']) ? filter_word(html_entities($_POST['seo_description'])) : '';
	isset($LAYOUTS[$layout]) || $layout = '1:2:1';
	
	
	$_layout = array(
		'left' => array('width' => $LAYOUTS[$layout]['left'], 'block' => array()),
		'center' => array('width' => $LAYOUTS[$layout]['center'], 'block' => array()),
		'right' => array('width' => $LAYOUTS[$layout]['right'], 'block' => array())
	);
	
	$ref_block = array();
	$for = array('left', 'center', 'right');
	foreach($for as $v){
		foreach($$v as $_block){
			if(
				!isset($_block['name']) ||// !isset($_block['alias']) ||
				!isset($BLOCKS[$_block['name']])
			) continue;
			
			if($BLOCKS[$_block['name']]['system'] == 'core'){
				$path = PHP168_PATH;
			}else{
				$path = PHP168_PATH . $BLOCKS[$_block['name']]['system'] .'/';
			}
			
			if($BLOCKS[$_block['name']]['module']){
				$path .= 'modules/'. $BLOCKS[$_block['name']]['module'] .'/homepage/';
			}
			
			$block = isset($blocks[$_block['name']]) ? $blocks[$_block['name']] : array();
			$block['name'] = $_block['name'];
			
			if(!empty($block['not_modified']) && isset($USER['homepage']['block'][$block['name']])){
				//没修改过的块
				$_layout[$v]['block'][$block['name']] = $USER['homepage']['block'][$block['name']];
			}else{
				//验证数据
				$_layout[$v]['block'][$_block['name']] = include $path .'block/'. $BLOCKS[$_block['name']]['method'] .'.valid.php';
			}
			
			//引用
			$ref_block[$_block['name']] = &$_layout[$v]['block'][$_block['name']];
		}
	}
	
	$homepage = array(
		'layout' => array(
			'' => $layout,
			
			'left' => $_layout['left'],
			'center' => $_layout['center'],
			'right' => $_layout['right']
		),
		'block' => $ref_block,
		'name' => $name,
		'banner' => $banner,
		'seo_keywords' => $seo_keywords,
		'seo_description' => $seo_description,
		'menus' => array()
	);
	
	$DB_master->update(
		$core->member_table,
		array(
			'homepage' => $DB_master->escape_string(serialize($homepage))
		),
		'id = \''. $UID .'\''
	);
	
	get_member($USER['username'], true);
	
	//DONE
	exit;
}