<?php
defined('PHP168_PATH') or die();

	//过滤非数字
	$id = isset($_REQUEST['id']) ? filter_int($_REQUEST['id']) : array();
	$id or exit('[]');
	
	$verified = isset($_REQUEST['verified']) && $_REQUEST['verified'] == 0 ? false : true;

	$T = $verified ? $this_module->main_table : $this_module->unverified_table;
	if($verified){
		$data = $this_module->data('read', $id[0]);
		$data or message('no_such_item');
	}else{
		
		$select = select();
		$select->from($this_module->unverified_table, 'data');
		$select->in('id', $id);
		$_data = $core->select($select, array('single' => true));
		$_data or message('no_such_item');
		
		$_data = mb_unserialize($_data['data']);
		$data = array_merge($_data['addon'], $_data['item'], $_data['main']);
		
	}
	//检查分类权限
	if(!$this_controller->check_category_action('delete', $data['cid'])){
		if($data['uid'] != $UID || $data['uid'] == $UID && $data['verified']) P8_AJAX_REQUEST? exit(jsonencode('no_category_privilege')) : message('no_category_privilege');
	}
	$ret = $this_controller->delete(array(
		'where' => $T .'.id IN ('. implode(',', $id) .')',
		'verified' => $verified,
		'delete_hook' => empty($_REQUEST['delete_hook']) ? false : true,
		'iid' => $id
	));
	 P8_AJAX_REQUEST? exit(jsonencode($id)) : message('done');
