<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('buy') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$aid = isset($_GET['aid']) ? $_GET['aid'] : 0;
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
	$postfix = isset($_GET['postfix']) ? preg_replace('/[^0-9a-zA-Z_\-]/', '', $_GET['postfix']) : '';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max($page, 1);

	$select = select();
	$select->from($this_module->buy_table .' AS b', 'b.*');
	$select->inner_join($this_module->table .' AS a', 'a.name', 'a.id = b.aid');

	$page_url = $this_url .'?page=?page?';
	$select->order('b.id DESC');

	if($aid){
		$select->in('b.aid', $aid);
		$page_url .= '&aid='. $aid;
		
		$select->order('b.display_order ASC, b.timestamp ASC');
	}


	$page_size = 20;
	$count = 0;
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size
		)
	);
	
	//echo $select->build_sql();

	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));

	include template($this_module, 'buy_list', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	//修改广告投放顺序
	$aid = isset($_POST['aid']) ? $_POST['aid'] : '';
	$order = isset($_POST['display_order']) ? (array)$_POST['display_order'] : array();
	
	$ids = $comma = '';
	foreach($order as $id => $order){
		$id = intval($id);
		if(!$id) continue;
		
		$ids .= $comma . $id;
		$comma = ',';
		
		$order = intval($order);
		
		$DB_master->update(
			$this_module->buy_table,
			array('display_order' => $order),
			"id = '$id'"
		);
	}
	
	if($ids){
		$query = $DB_master->query("SELECT aid, postfix FROM $this_module->buy_table WHERE id IN($ids)");
		$ad = array();
		while($arr = $DB_master->fetch_array($query)){
			$ad[$arr['aid']][$arr['postfix']] = 1;
		}
		
		foreach($ad as $aid => $v){
			foreach($v as $postfix => $vv){
				$this_module->js($aid, $postfix);
			}
		}
	}
	
	message('done');
	
}