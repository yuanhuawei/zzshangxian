<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('add') or message('no_privilege');

$this_system->init_model();
$this_model or message('no_such_cms_model');
$this_model['enabled'] or message('cms_model_disabled');

if(REQUEST_METHOD == 'GET'){
	
	$iid = isset($_GET['iid']) ? intval($_GET['iid']) : 0;
	$iid or message('no_such_item');

	$select = select();
	$select->from($this_module->table, 'id');
	$select->in('id', $iid);
	$data = $core->select($select, array('single' => true));
	$data or message('no_such_item');
	$data['cid'] = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
	$data['iid'] = $data['id'];
	//检查分类权限
	if($data['uid'] != $UID){
		$this_controller->check_category_action('add', $data['cid']) or message($P8LANG['cms_item']['no_category_privilege']);
	}
	require $this_model['path'] .'/member/addon.php';
	
	$template = empty($this_model['CONFIG']['member_edit_template']) ? 'edit' : $this_model['CONFIG']['member_edit_template'];
	
	include template($this_module, $template);
	
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	require $this_model['path'] .'/member/addon.php';
	
	$this_controller->addon($_POST) or message('fail');
	
	message('done');
	
}