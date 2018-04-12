<?php
defined('PHP168_PATH') or die();

$inajax = P8_AJAX_REQUEST ? true : false;

 if(REQUEST_METHOD == 'GET'){
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if(empty($id) || !$this_controller->check_exists(array('id'=>$id))){
		message('ask_error');
	}
	$item = $this_system->load_module('item');
	$select = select();
	
	$select->from($this_module->table_data . ' AS D', 'D.*');
	$select->left_join($this_module->table . ' AS T', 'T.tid, T.uid', 'T.id = D.id');
	$select->left_join($item->table . ' AS I', 'I.title, I.cid', 'I.id = T.tid');
	$select->in('D.id', $id);

	$data = &$core->select($select, array('single' => true));
	//检查分类权限
	if(!$this_controller->check_category_action($ACTION, $data['cid']) && $data['uid']!= $UID){
	 $inajax ? exit("['no_category_privilege']") : message("no_category_privilege");
	}
	$json = p8_json($data);
	$inajax ? exit($json): include template($this_module, 'edit');;
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	$_POST['content'] = isset($_POST['content']) ? ($inajax ? html_entities(from_utf8($_POST['content'])) : html_entities($_POST['content'])) : '';
	$status = $this_controller->update($_POST) or die();
	$inajax ? exit(jsonencode($status)) : message('done',$this_url."?id=".$_POST['id']);
}