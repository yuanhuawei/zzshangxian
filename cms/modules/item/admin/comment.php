<?php
defined('PHP168_PATH') or die();

/**
* 评论管理
**/

if(REQUEST_METHOD == 'GET'){

$this_controller->check_admin_action('comment') or message('no_privilege');

if(isset($_GET['verified'])){
	$verified = empty($_GET['verified']) ? 0 : 1;
}else{
	$verified = 1;
}
$very[$verified] = 'over';
$iid = isset($_GET['iid']) ? intval($_GET['iid']) : 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);

$page_url = $this_url .'?verified='. $verified .'&page=?page?';

$T = $verified == 0 ? $this_module->TABLE_ .'comment_unverified' : $this_module->TABLE_ .'comment';

$select = select();
$select->from($T .' AS c', 'c.id, c.iid, c.username, c.ip, c.timestamp, c.digg, c.oppose, c.content');
$select->inner_join($this_module->main_table .' AS i', 'i.title', 'i.id = c.iid');
$select->order('c.id DESC');

if($iid){
	$select->in('c.iid', $iid);
	$select->order('c.timestamp DESC');
	$page_url .= '&iid='. $iid;
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

include template($this_module, 'comment', 'admin');























	
}else if(REQUEST_METHOD == 'POST'){

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch($action){

case 'verify':
	$this_controller->check_admin_action('verify_comment') or exit('[]');
	
	//审核评论
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$value = empty($_POST['value']) ? 0 : 1;
	
	$ids = implode(',', $id);
	
	$query = $DB_master->query("SELECT m.id AS iid, m.model, c.* FROM {$this_module->TABLE_}comment_unverified AS c
	INNER JOIN $this_module->main_table AS m ON c.iid = m.id
	WHERE c.id IN ($ids)");
	
	$items = array();
	while($arr = $DB_master->fetch_array($query)){
		$items[$arr['iid']] = array(
			'model' => $arr['model'],
			'comments' => isset($items[$arr['iid']]['comments']) ? $items[$arr['iid']]['comments'] +1 : 1
		);
		
		unset($arr['model']);
		
		//移到己审核
		$DB_master->insert(
			$this_module->TABLE_ .'comment',
			$arr
		);
	}
	
	//删除未审核的
	$DB_master->delete(
		$this_module->TABLE_ .'comment_unverified',
		"id IN ($ids)"
	);
	
	foreach($items as $iid => $v){
		//更新内容的评论数
		$this_module->set_model($v['model']);
		
		$DB_master->update(
			$this_module->main_table,
			array('comments' => 'comments +'. $v['comments']),
			"id = '$iid'",
			false
		);
		
		$DB_master->update(
			$this_module->table,
			array('comments' => 'comments +'. $v['comments']),
			"id = '$iid'",
			false
		);
	}
	
	exit(jsonencode($id));
	
break;






















case 'delete':
	//删除评论
	
	$this_controller->check_admin_action('delete_comment') or exit('[]');
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$verified = isset($_POST['verified']) ? intval($_POST['verified']) : 1;
	
	//删除审核或未审核的
	$T = $verified == 0 ? $this_module->TABLE_ .'comment_unverified' : $this_module->TABLE_ .'comment';
	
	$ids = implode(',', $id);
	
	$query = $DB_master->query("SELECT m.id, c.iid, m.model FROM $T AS c
	INNER JOIN $this_module->main_table AS m ON c.iid = m.id
	WHERE c.id IN ($ids)");
	
	$items = array();
	while($arr = $DB_master->fetch_array($query)){
		if($verified){
			$items[$arr['id']] = array(
				'model' => $arr['model'],
				'comments' => isset($items[$arr['iid']]['comments']) ? $items[$arr['iid']]['comments'] +1 : 1
			);
		}
	}
	
	if(
		$num = $DB_master->delete(
			$T,
			'id IN ('. $ids .')'
		)
	){
		
		$DB_master->delete(
			$this_module->TABLE_ .'comment_id',
			"id IN ($ids)"
		);
		
		foreach($items as $iid => $v){
			//更新内容的评论数
			$this_module->set_model($v['model']);
			
			$DB_master->update(
				$this_module->main_table,
				array('comments' => 'comments -'. $v['comments']),
				"id = '$iid'",
				false
			);
			
			$DB_master->update(
				$this_module->table,
				array('comments' => 'comments -'. $v['comments']),
				"id = '$iid'",
				false
			);
		}
		
		exit(jsonencode($id));
	}
	
	exit('[]');
	
	
break;

}
	
}