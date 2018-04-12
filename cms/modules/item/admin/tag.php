<?php
defined('PHP168_PATH') or die();

/**
* 标签(tag)管理
**/
//message('制作中');
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max($page, 1);
	$name = isset($_GET['name']) ? $_GET['name'] : '';
	
	$page_url = $this_url .'?page=?page?';
	
	$select = select();
	$select->from($this_module->tag_table, '*');
	$select->order('display_order DESC');
	
	if(strlen($name)){
		$select->like('name', html_entities($name));
		$page_url .= '&name='. urlencode($name);
	}
	
	$page_size = 40;
	$count = 0;
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size,
			'ms' => 'master'
		)
	);
	
	//echo $select->build_sql();
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($this_module, 'tag', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	
	switch($action){
	
	/* 排序 */
	case 'order':
		
		$order = isset($_POST['display_order']) ? (array)$_POST['display_order'] : array();
		foreach($order as $id => $value){
			if(!($id = intval($id))) continue;
			
			$value = intval($value);
			
			$DB_master->update(
				$this_module->tag_table,
				array('display_order' => $value),
				"id = '$id'"
			);
		}
		
		message('done');
		
	break;
	
	/* 统计 */
	case 'statistic':
		
		$query = $DB_master->query("SELECT tid, COUNT(*) AS `count` FROM $this_module->tag_item_table GROUP BY tid");
		while($arr = $DB_master->fetch_array($query)){
			$DB_master->update(
				$this_module->tag_table,
				array('item_count' => $arr['count']),
				"id = '$arr[tid]'"
			);
		}
		
		message('done');
	break;
	
	/* 删除 */
	case 'delete':
		$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$id or exit('[]');
		
		$ids = implode(',', $id);
		
		if($ids && $DB_master->delete(
			$this_module->tag_table,
			"id IN ($ids)"
		)){
			
			$DB_master->delete(
				$this_module->tag_item_table,
				"tid IN ($ids)"
			);
			
			exit(p8_json($id));
		}
		
		exit('[]');
	break;
	
	}
	
}