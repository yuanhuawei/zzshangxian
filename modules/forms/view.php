<?php
defined('PHP168_PATH') or die();

/**
* 查看内容入口文件
**/

//$this_controller->check_action($ACTION) or message('no_privilege');
$id = 0;
$id = isset($_GET['id'])? intval($_GET['id']): 0;
foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'id':
			$id = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			$PAGE_CACHE_PARAM['id'] = $id;
			break 2;
		break;
	}
}
$id or message('no_such_item');
if(isset($id)){
	$data = $this_module->get_data($id);
	$data or message('no_such_item');

	$mid = $data['mid'];
	$this_module->set_model($mid) or message('no_such_model');
	if(!$data['status'] && !$this_controller->check_model_action('manage',$mid)){
		if(empty($this_model['CONFIG']['viewself']) && $data['uid'] == $UID || $data['uid'] != $UID)
		message('no_model_privilege');
	}
	if(!$this_controller->check_model_action($ACTION,$mid) && $data['uid'] != $UID){
		message('no_model_privilege');
	}	
	
	$manage = $this_controller->check_model_action('manage',$mid);
}

if(REQUEST_METHOD == 'GET'){
	if(!empty($this_model['CONFIG']['viewhash'])){
		$viewcode = $_GET['viewcode'];
		if(!$viewcode)message('no_privilege');
		$encode = p8_code($viewcode,false);
		list($_id,$datetime) = explode('_',$encode);
		if($_id!=$id || P8_TIME-$datetime>3600 || P8_TIME-$datetime<0)message('no_privilege');
	}
		
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $this_model['alias'];	
	
	$data = $this_module->get_data($id,$this_model['name']);
	$data or message('no_such_item');
	$this_module->format_data($data);
	$this_module->format_view($data);
	$status = $this_module->CONFIG['status'];
	//模型自定义脚本
	include $this_model['path'] .'view.php';
	
	$template = empty($this_model['view_template'])? 'view' : 'tpl/'.$this_model['view_template'];

		$core->get_cache('role_group');
		$member = $core->load_module('member');
		$member->set_model($ROLE_GROUP);
		$member_info = $member->get_member_info($UID);
	
	$status_json = p8_json($this_module->CONFIG['status']);
	include template($this_module, $template);

}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	if(!$this_controller->check_action('verify')){
		unset($_POST['verify']);
	}
	
	
	$status = $this_controller->update($id, $_POST) or message('fail');
	
	if($_POST['verify']){
		message('verifing');
	}else{
		message('done');
	}
	
}