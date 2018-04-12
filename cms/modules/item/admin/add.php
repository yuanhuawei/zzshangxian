<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(isset($_REQUEST['model'])){
	$this_system->init_model();
	$data['cid'] = isset($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '';
	if($data['cid'] && !$this_controller->check_category_action('add', $data['cid'])) message($P8LANG['cms_item']['no_category_privilege']);
	
	$this_model or message('no_such_cms_model');
	
	$this_model['enabled'] or message('cms_model_disabled');
	
}else{
	$models = $this_system->get_models();
	
	if(count($models) == 1){
		header('Location: '. $this_url .'?model='. current(array_keys($models)));
	}else{
		include template($this_module, 'select_model', 'admin');
	}
	exit;
}

if(REQUEST_METHOD == 'GET'){
	
	$my_addible_category = p8_json($this_controller->get_acl('my_addible_category'));
	$allow_verify = $this_controller->check_admin_action('verify');
	$allow_attribute = $this_controller->check_admin_action('attribute');
	$allow_list_order = $this_controller->check_admin_action('list_order');
	$allow_create_time = $this_controller->check_admin_action('create_time');
	
	$data = array();
	
	isset($_GET['cid']) && $data['cid'] = $_GET['cid'];
	$data['wenhao'] = 'xxgk'.date('Ymd',P8_TIME).rand(1000,9999);
	$attributes = array();
	
	require $this_model['path'] .'/admin/add.php';
	
	$template = empty($this_model['CONFIG']['admin_edit_template']) ? 'edit' : $this_model['CONFIG']['admin_edit_template'];
	
	include template($this_module, $template, 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	if(!$this_controller->check_admin_action('verify')){
		unset($_POST['verify']);
	}
	$_POST['verifier']='';
	//检查分类自动审核权限
	if($this_controller->check_category_action('autoverify', $_POST['cid'])){
		$_POST['verify'] = 1;
		$_POST['verifier'] = $USERNAME;
	}
	require $this_model['path'] .'/admin/add.php';
	
	$ADMIN_LOG = array('title' => $P8LANG['_module_add_admin_log']);
	
	//分页
	$content = array();
	if(isset($_POST['field#']['content'])){
		$content = preg_split('#<div style="page-break-after:\s*?always;?">\s*?<span style="display: none;?">.*?</span>\s*?</div>#is', $_POST['field#']['content']);
		
		$_POST['field#']['content'] = array_shift($content);
	}

	$id = $this_controller->add($_POST) or message('fail');
	
	foreach($content as $v){
		$_POST['field#']['content'] = $v;
		$_POST['iid'] = $id;
		$_POST['action'] = 'addon';
		$this_controller->addon($_POST);
	}
	
	message(
		array(
			array('cms_to_edit', $this_module->admin_controller .'-update?id='. $id .'&model='. $_POST['model']),
			array('cms_to_list', $this_module->admin_controller .'-list?cid='. $_POST['cid'].'&model='. $_POST['model']),
			array('cms_to_view', $this_module->controller .'-view-id-'.$id .'?verify='. $_POST['verify'], '_blank'),
			array('cms_to_add', $this_module->admin_controller .'-add?cid='. $_POST['cid']. '&model='. $_POST['model'])
		),
		$this_module->admin_controller .'-add?cid='. $_POST['cid'] .'&model='. $_POST['model'],
		10000
	);

}