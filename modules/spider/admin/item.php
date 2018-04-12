<?php
defined('PHP168_PATH') or die();

/**
* 采集内容管理
**/

$this_controller->check_admin_action('item') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	if($id){
		
		//查看内容
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page = max($page, 1);
		
		$ret = $this_module->get_item(array('where' => "id = '$id'"));
		$data = array_shift($ret);
		$data or message('no_such_item');
		
		$count = $data['pages'];
		$data = $data['data'];
		
		$page_url = $this_url .'?id='. $id .'&page=?page?';
		
		if($page > 1){
			//分页
			$data = $this_module->get_item(array(
				'iid' => $id,
				'offset' => $page -2,
				'limit' => 1
			));
			$data or message('no_such_item');
			
			$data = array_shift($data);
			$data = $data['data'];
		}
		
		$pages = list_page(array(
			'count' => $count,
			'page' => $page,
			'page_size' => 1,
			'url' => $page_url,
		));
		
		include template($this_module, 'item_view', 'admin');
		exit;
	}
	
	$rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;
	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	
	$page_url = $this_url .'?page=?page?';
	
	$this_module->get_cache();
	
	$select = select();
	$select->from($this_module->item_table .' AS i', 'i.id, i.rid, i.title, i.pages, i.timestamp');
	$select->inner_join($this_module->rule_table .' AS r', 'r.name AS rule_name', 'i.rid = r.id');
	$select->left_join($this_module->category_table .' AS c', 'c.name AS category', 'r.cid = c.id');
	$select->order('id ASC');
	if($rid){
		$select->in('i.rid', $rid);
		$page_url .= '&rid='. $rid;
		$select->order('i.timestamp ASC');
	}
	
	//echo $select->build_sql();
	
	$count = 0;
	$page_size = 20;
	
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size
		)
	);
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($this_module, 'item', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	
	switch($action){
	
	case 'count':
		define('NO_ADMIN_LOG', true);
		
		$rid = isset($_POST['rid']) ? intval($_POST['rid']) : 0;
		$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
		
		$where = '';
		if($rid){
			$where = "rid = '$rid'";
		}else if($id){
			$where = 'id IN ('. implode(',', $id) .')';
		}else{
			exit('0');
		}
		
		exit($this_module->get_item(array(
			'where' => $where,
			'count' => true
		)));
	break;
	
	case 'delete':
		$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
		//按规则删
		$rid = isset($_POST['rid']) ? intval($_POST['rid']) : 0;
		$hook = empty($_POST['hook']) ? false : true;
		
		if($id || $rid){
			$this_module->delete_item(array(
				'where' => $rid ? "rid = '$rid'" : 'id IN ('. implode(',', $id) .')',
				'hook' => $hook
			));
		}
		
		exit(p8_json($id));
	break;
	
	}
	
}