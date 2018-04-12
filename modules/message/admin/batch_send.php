<?php
defined('PHP168_PATH') or die();

/**
* 批量发送
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$action = isset($_GET['action']) ? $_GET['action'] : 'send';
	
	$role = &$core->load_module('role');
	$role->get_cache();
	
	if($action == 'list'){
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page = max(1, $page);
		
		$select = select();
		$select->from($this_module->table, 'id, role_id, title, timestamp');
		$select->in('sendee_uid', 0);
		$select->in('sender_uid', 0);
		$select->order('role_id ASC, timestamp DESC');
		
		$count = 0;
		$list = $core->list_item(
			$select,
			array(
				'page' => $page,
				'count' => $count,
				'page_size' => 20
			)
		);
	}else if($action == 'edit'){
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$id or message('no_such_item');
		
		$select = select();
		$select->from($this_module->table, '*');
		$select->in('id', $id);
		
		$data = $core->select($select, array('single' => true));
		$data or message('no_such_item');
		
	}
	
	include template($this_module, 'batch_send', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	$action = isset($_POST['action']) ? $_POST['action'] : 'send';
	$role_id = isset($_POST['role_id']) ? filter_int($_POST['role_id']) : array();
	$title = isset($_POST['title']) ? html_entities($_POST['title']) : '';
	$acl = $core->load_acl('core', '', $core->ROLE);
	$content = isset($_POST['content']) ? attachment_url(p8_html_filter($_POST['content'], $acl['allow_tags'], $acl['disallow_tags'])) : '';
	
	if($action == 'send'){
		
		if(empty($role_id)){
			
			$data = array(
				'role_id' => 0,
				'title' => $title,
				'content' => $content
			);
			
			$this_module->send($data);
			
		}else{
			
			foreach($role_id as $v){
				$data = array(
					'role_id' => $v,
					'title' => $title,
					'content' => $content
				);
				
				$this_module->send($data);
			}
		}
		
	}else{
		
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$id or message('no_such_item');
		
		$DB_master->update(
			$this_module->table,
			array(
				'title' => $title,
				'content' => $content
			),
			"id = '$id'"
		);
		
	}
	
	message('done');
	
}