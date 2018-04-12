<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

 if(REQUEST_METHOD == 'GET'){
	message('ask_error', $this_system->controller, 3);
}else if(REQUEST_METHOD == 'POST'){
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	$this_controller->check_category_action($ACTION,$_POST['cid']) or message('my_category_to_verify');
	
	$url = $this_controller->post($_POST) or message('ask_error', $this_system->controller, 3);

	$position = $this_system->position . '&nbsp;&gt;&nbsp;' . $P8LANG['ask_submit_answer'];

	$sitename = $P8LANG['ask_submit_answer'] . ' - ' . $this_system->sitename;
	$keywords = $this_system->keywords;
	$description = $this_system->description; 

	$item = $this_module->system->load_module('item');
	$query = $DB_master->fetch_all("SELECT title,id FROM $item->table WHERE status=1 AND verify=1 AND endtime>".P8_TIME." AND closed=0 LIMIT 20");
	foreach($query as $key=>$val){
		$list[$key]['title']=$val['title'];
		$list[$key]['url']=$item->controller.'-view-id-'.$val['id'];

	}

	include template($this_module, 'post_success');
}