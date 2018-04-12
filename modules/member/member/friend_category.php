<?php
defined('PHP168_PATH') or die();

/**
* 好友分组管理
**/

if(REQUEST_METHOD == 'GET'){
	
	load_language($this_module, 'friend');
	
	$query = $DB_slave->query("SELECT id, name, members FROM $this_module->friend_category_table WHERE uid = '$UID'");
	$categories = array();
	while($arr = $DB_slave->fetch_array($query)){
		$categories[$arr['id']] = $arr;
		unset($categories[$arr['id']]['id']);
	}
	
	
	if(P8_AJAX_REQUEST){
		//AJAX请求
		
		$json = jsonencode($categories);
		//jsonp?
		$callback = isset($_GET['callback']) ? $_GET['callback'] : '';
		
		exit($callback ? $callback .'('. $json .');' : $json);
	}else{
		
		include template($this_module, 'friend_category');
	}
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	
	$this_module->delete_friend_category($id) or exit('[]');
	
	exit(jsonencode($id));
}