<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);

	$page_url = $this_router .'-'. $ACTION .'?page=?page?';
	$count = 0;
	$select = select();
	$select -> from($this_module->model_table,'*');
	$select -> order('display_order DESC, id DESC');
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);

	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $page_url
	));
	
	include template($this_module, 'model', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$action = isset($_POST['action'])? $_POST['action'] : '';
	
	if($action == 'cache'){
		$this_module->cache();
	}else if($action == 'delete'){
		$status = $this_controller->delete_model($_POST);
		echo $status;
		exit;
	}else if($action == 'html'){
		
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		
		$this_module->html($id);
		
		message('done', HTTP_REFERER);exit;
		
	}else if($action == 'clean'){
		//if(!$IS_FOUNDER)message('no_privilege');
		
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		
		$this_module->clean($id);
		
		message('done', HTTP_REFERER);exit;
		
	}else{
		//批量修改字段的排序
		$display_order = isset($_POST['_display_order']) && is_array($_POST['_display_order']) ? array_map('intval', $_POST['_display_order']) : array();
		
		foreach($display_order as $id => $order){
			$DB_master->update(
				$this_module->model_table,
				array(
					'display_order' => $order
				),
				"id = '$id'"
			);
		}
	}
	
	message('done', $this_url);

}