<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	@set_time_limit(60);
	
	$MODEL = isset($_GET['model']) ? $_GET['model'] : '';

	$models = $this_system->get_models();

	$this_module->get_cache(false);
	$path = array();
	
	foreach($this_module->categories as $v){
		$parents = $this_module->get_parents($v['id']);
		foreach($parents as $vv){
			$path[$v['id']][] = $vv['id'];
		}
		$path[$v['id']][] = $v['id'];
	}
	
	$json = array(
		'json' => p8_json($this_module->make_json_sort($this_module->top_categories)),
		'path' => p8_json($path),
		'models' => p8_json($models)
	);

	include template($this_module, 'list', 'admin');
	//print_r($this_module->top_categories);
}else if(REQUEST_METHOD == 'POST'){
	
	@set_time_limit(0);
	
	$action = @$_POST['action'];
	
	switch($action){
	
	case 'fix':
		//修复栏目内容数
		$DB_master->update($this_module->table, array('item_count' => 0), '');
		
		$query = $DB_master->query("SELECT cid, COUNT(*) AS `count` FROM $this_system->item_table GROUP BY cid");
		while($arr = $DB_master->fetch_array($query)){
			$this_module->update_count($arr['cid'], $arr['count']);
		}
	break;
	
	case 'cache':
		//更新缓存
		$this_module->cache();
	break;
	
	case 'unhtmlize':
	case 'htmlize':
		//开启/关闭所有静态化
		$DB_master->update(
			$this_module->table,
			array('htmlize' => $action == 'htmlize' ? 1 : 0),
			''
		);
	
		$this_module->cache();
	break;
	
	case 'conten_unhtmlize':
	case 'conten_htmlize':
		//开启/关闭所有内容页静态化
		$DB_master->update(
			$this_module->table,
			array('htmlize' => $action == 'conten_htmlize' ? 2 : 0),
			''
		);
	
		$this_module->cache();
	break;
	
	default:
		//批量修改栏目排序
		$display_order = isset($_POST['_display_order']) ? array_map('intval', (array)$_POST['_display_order']) : array();
		
		foreach($display_order as $id => $order){
			$id = intval($id);
			
			$DB_master->update(
				$this_module->table,
				array('display_order' => $order),
				"id = '$id'"
			);
		}
		
		$display_order && $this_module->cache();
		
	}
	
	message('done');
	
}