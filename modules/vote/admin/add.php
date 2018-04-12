<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$core->get_cache('role');
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$id = $this_controller->add($_POST) or message('fail');
	
	//Ìí¼ÓÑ¡Ïî
	$option_name = isset($_POST['option_name']) ? (array)$_POST['option_name'] : array();
	$option_order = isset($_POST['option_order']) ? (array)$_POST['option_order'] : array();
	$option_frame = isset($_POST['option_frame']) ? (array)$_POST['option_frame'] : array();
	$option_description = isset($_POST['option_description']) ? (array)$_POST['option_description'] : array();
	$option_url = isset($_POST['option_url']) ? (array)$_POST['option_url'] : array();
	
	foreach($option_name as $k => $v){
		if(!strlen($v)) continue;
		
		$DB_master->insert(
			$this_module->option_table,
			array(
				'vid' => $id,
				'name' => html_entities($v),
				'description' => isset($option_description[$k]) ? html_entities($option_description[$k]) : '',
				'frame' => isset($option_frame[$k]) ? attachment_url(html_entities($option_frame[$k]), true) : '',
				'url' => isset($option_url[$k]) ? attachment_url(html_entities($option_url[$k]), true) : '',
				'display_order' => isset($option_order[$k]) ? intval($option_order[$k]) : 0
			)
		);
	}
	
	$this_module->cache($id);
	
	message('done', $this_router .'-list');
}