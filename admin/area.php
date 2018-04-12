<?php
defined('PHP168_PATH') or die();

/**
* 地区管理
**/

$this_controller->check_admin_action('area') or message('no_privilege');

require_once PHP168_PATH .'inc/area.class.php';
$area = new P8_Area();
load_language($core, 'area');


if(REQUEST_METHOD == 'GET'){
	
	$act = isset($_GET['act']) ? $_GET['act'] : '';

	$parent = isset($_GET['parent']) ? intval($_GET['parent']) : 0;
	
	$parents = array();
	$sql = "SELECT * FROM $area->table WHERE parent = '$parent' LIMIT 1";
	
	do{
		if(empty($data)){
			$data = array(
				'parent' => $parent
			);
		}
		array_unshift($parents, $data['parent']);
		$sql = "SELECT * FROM $area->table WHERE id = '$data[parent]' LIMIT 1";
		
	}while($data = $DB_master->fetch_one($sql));
	
	$select = select();
	$select->from($area->table, '*');
	$select->in('parent', $parents);
	$select->order('display_order DESC');
	
	
	$list = $core->list_item(
		$select,
		array(
			'count' => 0,
			'page' => 0
		)
	);
	
	/*
	foreach($parents as $n => $p){
		foreach($list as $k => $v){
			if($v['parent'] == $p){
				if(isset($parents[$n +1])) unset($list[$k]);
			}
		}
	}*/
	
	include template($core, 'area_list', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$act = isset($_POST['act']) ? $_POST['act'] : '';
	
	switch($act){
	
	case 'cache':
		$area->cache();
		
		message('done', HTTP_REFERER);
	break;
	
	case 'import':
		require_once PHP168_PATH .'install/install.func.php';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		
		switch($type){
		
		case 'province':
			$file = PHP168_PATH .'install/province.txt';
		break;
		
		case 'city':
			$file = PHP168_PATH .'install/city.txt';
		break;
		
		case 'town':
			$file = PHP168_PATH .'install/area.txt';
		break;
		
		}
		
		$sql = get_install_sql(
			$DB_master,
			file_get_contents($file),
			$core->TABLE_
		);
		
		foreach($sql as $v){
			$DB_master->query($v);
		}
		
		$area->cache();
		
		message('done', HTTP_REFERER);
	break;
	
	}
	
	$parent = isset($_POST['parent']) ? intval($_POST['parent']) : 0;
	$post = isset($_POST['post']) ? (array)$_POST['post'] : array();
	$name = isset($post['name']) ? (array)$post['name'] : array();
	
	foreach($name as $k => $v){
		if(isset($post['name'][$k])) continue;
		
		$area->add(array(
			'parent' => $parent,
			'name' => isset($post['name'][$k]),
			'display_order' => isset($post['display_order'][$k]) ? $post['display_order'][$k] : 0
		));
	}
	
	$updates = isset($_POST['update']) ? filter_int($_POST['update']) : array();
	foreach($updates as $v){
		$DB_master->update(
			$area->table,
			array(
				'name' => isset($_POST['name'][$v]) ? html_entities($_POST['name'][$v]) : '',
				'display_order' => isset($_POST['display_order'][$v]) ? html_entities($_POST['display_order'][$v]) : '',
			),
			"id = '$v'"
		);
	}
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	if($id){
		$DB_master->delete(
			$area->table,
			'id IN ('. implode(',', $id) .')'
		);
	}
	
	message('done', HTTP_REFERER);
	
}