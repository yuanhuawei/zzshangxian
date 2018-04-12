<?php
defined('PHP168_PATH') or die();
$this_controller->check_admin_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){
$job=isset($_GET['job'])?$_GET['job']:'list';

	if($job=='edit'){
	
		$id = !empty($_GET['id'])? intval($_GET['id']):'';
		if(!$id)return false;
		$data = $this_module->get_category($id);
		$data = $data[0];
		include template($this_module, 'add', 'admin');
		
	}else
	if($job=='add'){
	
		include template($this_module, 'add', 'admin');
		
	}else
	if($job=='delete'){
		$id = !empty($_GET['id'])? intval($_GET['id']):'';
		$this_module->delete_category($id);
		message('done');
	}else
	if($job=='list'){
	
		$list = $this_module->get_category();
		include template($this_module, 'category', 'admin');
	}

}else if(REQUEST_METHOD=='POST'){
$job=isset($_POST['job'])?$_POST['job']:'list';
	
	if($job=='edit'){
	
		$this_controller->edit_category(&$_POST);
		message('done');
		
	}else
	if($job=='add'){
	
		$this_controller->add_category(&$_POST);
		message('done');
		
	}else
	if($job=='list'){
	
		$this_module->cache();
		message('done');
	}
}
?>