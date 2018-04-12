<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

load_language($this_system, 'admin');

if(REQUEST_METHOD == 'GET'){

	$category = $this_system->load_module('category');
	$category->cache(false, false);
	$json = $category->get_json();	
	$reward = array();
	$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	if(empty($id) || !$this_controller->check_exists(array('id'=>$id))){
		message('ask_not_chose_record', HTTP_REFERER, 3);
	}
		
	//积分列表
	$reward = explode("\r\n",$this_system->CONFIG['reply_credit']);
	
	$select = select();
	$select -> from($this_module->table . ' AS T', 'T.*');
	$select -> left_join($this_module->table_data . ' AS D', 'D.tel,D.info,D.content', 'T.id=D.id');
	$select -> in('T.id', $id);
	$data = $core->select($select, array('single' => true));
	$data['tags'] = $this_controller->get_itemtags(array('id'=>$id));

	//所属分类
	$category_location = '<input type="radio" value="' . $data['cid'] . '" checked="checked"/> '; 
	$_category_location = '';
	$parents = $category->get_parents(intval($data['cid']));
	foreach($parents as $k=> $v){
		$_category_location .= $v['name'] . '&nbsp;&gt;&nbsp;';
	}
	$category_location .= $_category_location . $category->categories[(int)$data['cid']]['name'];
	
	include template($this_module, 'edit', 'admin');
	
}
elseif(REQUEST_METHOD == 'POST'){

	$page = !empty($_POST['page']) ? intval($_POST['page']) : 1;

	$this_controller->update($_POST) or message('ask_error', HTTP_REFERER, 3);

	message('ask_success_update_item', $this_router.'-list?page='.$page, 3);
	
}