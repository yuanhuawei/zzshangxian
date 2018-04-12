<?php
defined('PHP168_PATH') or die();

/**
* 修改投票
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $DB_master->fetch_one("SELECT * FROM $this_module->table WHERE id = '$id'");
	$data or message('no_such_item');
	
	$options = array();
	$query = $DB_master->query("SELECT * FROM $this_module->option_table WHERE vid = '$id' ORDER BY display_order, id ASC");
	while($arr = $DB_master->fetch_array($query)){
		$arr['frame'] = attachment_url($arr['frame']);
		$options[$arr['id']] = $arr;
	}
	$data['roles'] = array_flip(explode('|', $data['roles']));
	$data['frame'] = attachment_url($data['frame']);
	$core->get_cache('role');
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$option_name = isset($_POST['option_name']) ? (array)$_POST['option_name'] : array();
	$option_order = isset($_POST['option_order']) ? (array)$_POST['option_order'] : array();
	$option_description = isset($_POST['option_description']) ? (array)$_POST['option_description'] : array();
	$option_frame = isset($_POST['option_frame']) ? (array)$_POST['option_frame'] : array();
	$option_url = isset($_POST['option_url']) ? (array)$_POST['option_url'] : array();
	
	//delete
	foreach($option_name as $k => $v){
		//删掉要删除的
		if(!strlen($v)){
			$k = intval($k);
			
			$DB_master->delete($this_module->option_table, "id = '$k'");
			$DB_master->delete($this_module->voter_table, "oid = '$k'");
			
			unset($option_name[$k]);
		}
	}
	
	//update
	$query = $DB_master->query("SELECT * FROM $this_module->option_table WHERE vid = '$id'");
	while($arr = $DB_master->fetch_array($query)){
		
		if(isset($option_name[$arr['id']])){
			$DB_master->update(
				$this_module->option_table,
				array(
					'name' => html_entities($option_name[$arr['id']]),
					'description' => isset($option_description[$arr['id']]) ? html_entities($option_description[$arr['id']]) : '',
					'frame' => isset($option_frame[$arr['id']]) ? attachment_url(html_entities($option_frame[$arr['id']]), true) : '',
					'url' => isset($option_url[$arr['id']]) ? html_entities($option_url[$arr['id']]) : '',
					'display_order' => empty($option_order[$arr['id']]) ? $arr['id'] : intval($option_order[$arr['id']])
				),
				"id = '$arr[id]'"
			);
			
			unset($option_name[$arr['id']]);
		}
	}

	//add
	foreach($option_name as $k => $v){
		$oid = $DB_master->insert(
			$this_module->option_table,
			array(
				'vid' => $id,
				'name' => html_entities($v),
				'description' => isset($option_description[$k]) ? html_entities($option_description[$k]) : '',
				'frame' => isset($option_frame[$k]) ? attachment_url(html_entities($option_frame[$k]), true) : '',
				'url' => isset($option_url[$k]) ? attachment_url(html_entities($option_url[$k])) : '',
				'display_order' => isset($option_order[$k]) ? intval($option_order[$k]) : 0
			),
			array('return_id'=>1)
		);
		$DB_master->update(
				$this_module->option_table,
				array(
					'display_order' => $oid
				),
				"id = '$oid'"
			);
	}
	
	
	$this_controller->update($id, $_POST);
	
	$this_module->cache($id);
	
	message('done', HTTP_REFERER);
}