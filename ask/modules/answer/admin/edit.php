<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

P8_AJAX_REQUEST or message('ask_error');

load_language($this_system, 'admin');

if(REQUEST_METHOD == 'GET'){

	//载入分类模块
	$item = &$this_system->load_module('item');

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if(empty($id) || !$this_controller->check_exists(array('id'=>$id))){
		message('ask_error');
	}

	$select = select();
	$select->from($this_module->table . ' AS A', "A.*");
	$select->left_join($this_module->table_data . ' AS D', 'D.content', 'D.id=A.id');
	$select->left_join($item->table . ' AS I', 'I.title', 'A.tid=I.id');
	$select->in('A.id', $id);
	$data = &$core->select($select, array('single' => true));
	$data['item_url'] = p8_url($item, $data, 'view');

	include template($this_module, 'edit', 'admin');

}
elseif(REQUEST_METHOD == 'POST'){
	
	/*$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$uptime = !empty($_POST['uptime']) ? true : false;
	$content = isset($_POST['content']) ? html_entities(from_utf8($_POST['content'])) : '';
	$json = array();

	if(empty($id) || !is_numeric($id) || !$this_controller->check_exists($id)){
		die();
	}

	$json = $this_controller->update($id, $uptime, $content);
	if(!empty($json['content'])){
		$json['summary'] = P8_cutstr(strip_tags(html_decode_entities($json['content'])),30);
	}*/

	$json = $this_controller->update($_POST) or die();
	echo jsonencode($json);
	exit;

}