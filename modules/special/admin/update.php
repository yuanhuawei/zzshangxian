<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('edit') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$id=$_GET['id'];
	if(!$id)message('no id ');
	$json = $this_module->category->get_json();
	$rsdb=$DB_master->fetch_one("SELECT * FROM {$this_module->category->table} WHERE id='$id'");
	include template($this_module, 'update', 'admin');
}else if(REQUEST_METHOD == 'POST'){
	$data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	
	if(!empty($data['name']) && $id){

			$data['type']=isset($_POST['type'])? $_POST['type'] : '2';
			$data['parent'] = isset($_POST['parent']) ? intval($_POST['parent']) : 0;
			$this_module->category->update($id,$data) or message('fail');
			$this_module->category->cache(false, true, $id);
			
		}
		message("done",$this_router.'-category_list');
}