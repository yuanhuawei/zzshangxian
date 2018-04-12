<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('list') or message('no_privilege');

$this_system->init_model();

if(REQUEST_METHOD == 'GET'){
	
	$iid = isset($_GET['iid']) ? intval($_GET['iid']) : 0;
	$iid or message('no_such_item');
	
	if(isset($_GET['verified'])){
		$verified = $_GET['verified'] == 1 ? true : false;
	}else{
		$verified = true;
	}

	$select = select();
	if($verified){
		$select->from($this_module->table, 'id, cid, title, model, pages');
	}else{
		$select->from($this_module->unverified_table, 'id, cid, title, model, pages');
	}
	
	$select->in('id', $iid);
	$data = $core->select($select, array('single' => true, 'ms' => 'master'));
	$data or message('no_such_item');
	
	$select = select();
	$select->from($this_module->addon_table, 'id, iid, addon_title, page');
	$select->in('iid', $iid);
	$select->in('page', 1, true);
	$select->order('page ASC');
	
	$list = $core->list_item(
		$select,
		array(
			'page' => 0,
			'ms' => 'master'
		)
	);
	
	//echo $select->build_sql();
	
	include template($this_module, 'list_addon', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$iid = isset($_POST['iid']) ? intval($_POST['iid']) : 0;
	$iid or message('no_such_item');
	
	function _filter($v){
		return $v != 1 && $v;
	}
	
	//批量修改页码,不能修改第一页
	$page = isset($_POST['_new_page']) ? array_unique(array_filter(array_map('intval', (array)$_POST['_new_page']), '_filter')) : array();
	
	foreach($page as $id => $new_page){
		$DB_master->update(
			$this_module->addon_table,
			array('page' => $new_page),
			"id = '$id'"
		);
	}
	
	message('done');
}