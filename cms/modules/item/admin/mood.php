<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if(REQUEST_METHOD == 'GET'){
	
	$select = select();
	$select->from($this_module->TABLE_ .'mood', '*');
	$select->order('display_order DESC');
	
	$list = $core->list_item(
		$select,
		array(
			'page' => 0,
			'ms' => 'master'
		)
	);
	
	include template($this_module, 'mood', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$deletes = isset($_POST['delete_id']) ? filter_int($_POST['delete_id']) : array();
	//有删除的
	foreach($deletes as $id){
		$DB_master->delete(
			$this_module->TABLE_ .'mood',
			"id = '$id'"
		);
		$DB_master->query("ALTER TABLE {$this_module->TABLE_}mood_data DROP m$id");
	}
	
	//有新添加的
	if(
		!empty($_POST['new_name']) && 
		!empty($_POST['new_image'])
	){
		
		foreach($_POST['new_name'] as $k => $v){
			
			if(empty($_POST['new_name'][$k]) || empty($_POST['new_image'][$k])) continue;
			
			$id = $DB_master->insert(
				$this_module->TABLE_ .'mood',
				array(
					'name' => html_entities($_POST['new_name'][$k]),
					'image' => html_entities($_POST['new_image'][$k]),
					'display_order' => intval($_POST['new_display_order'])
				),
				array('return_id' => true)
			);
			
			$DB_master->query("ALTER TABLE {$this_module->TABLE_}mood_data ADD m$id mediumint(8) unsigned NOT NULL default '0'");
		}
		
	}
	
	
	//有修改的
	$changes = isset($_POST['changes']) ? filter_int($_POST['changes']) : array();
	
	foreach($changes as $id){
		
		$name = isset($_POST['name'][$id]) ? html_entities($_POST['name'][$id]) : '';
		$image = isset($_POST['image'][$id]) ? html_entities($_POST['image'][$id]) : '';
		$display_order = isset($_POST['display_order'][$id]) ? intval($_POST['display_order'][$id]) : 0;
		if(empty($name) || empty($image)) continue;
		
		$DB_master->update(
			$this_module->TABLE_ .'mood',
			array(
				'name' => $name,
				'image' => $image,
				'display_order' => $display_order
			),
			"id = '$id'"
		);
	}
	
	$this_module->cache();
	
	message('done', HTTP_REFERER);

}