<?php
defined('PHP168_PATH') or die();

/**
* 添加模型内容入口文件
**/

$this_controller->check_action($ACTION) or message('no_privilege');

if(isset($_REQUEST['model'])){
	$this_system->init_model();
	$this_model or message('no_such_cms_model');
	$this_model['enabled'] or message('cms_model_disabled');
	
}else{
	$models = $this_system->get_models();
	foreach($models as $k=>$m){
		if(!$m['enabled'])unset($models[$k]);
	}
	if(count($models) == 1){
		header('Location: '. $this_url .'?model='. current(array_keys($models)));
	}else{
		include template($this_module, 'select_model');
	}
	exit;
}

if(REQUEST_METHOD == 'GET'){
	$_my_addible_category = $this_controller->get_acl('my_addible_category');
	$my_addible_category = p8_json($_my_addible_category);
	$allow_verify = $this_controller->check_action('verify');
	$allow_create_time = $this_controller->check_action('create_time');
	$allow_attribute = $this_controller->check_action('attribute');
	
	$data = array();

	if(isset($_GET['cid'])){
		if(!$this_controller->check_category_action('add',intval($_GET['cid'])))message($P8LANG['cms_item']['no_category_privilege']);
		$data['cid'] = intval($_GET['cid']);
	
	}
	$data['wenhao'] = 'xxgk'.date('Ymd',P8_TIME).rand(1000,9999);
	$attributes = array();
	
	
	require $this_model['path'] .'/member/add.php';
	
	$template = empty($this_model['CONFIG']['member_edit_template']) ? 'edit' : $this_model['CONFIG']['member_edit_template'];
	
	include template($this_module, $template);
	
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	

	
	//检查分类自动审核权限
	unset($_POST['verify']);
	$_POST['verifier']='';
	if($this_controller->check_category_action('autoverify', $_POST['cid'])){
		$_POST['verify'] = 1;
		$_POST['verifier'] = $USERNAME;
	}
	
	require $this_model['path'] .'/member/add.php';
	
	$id = $this_controller->add($_POST) or message('fail');
	
	if($_POST['verify']){
		message(
			array(
				array('cms_to_edit', $this_module->U_controller .'-update?id='.$id.'&model='.$_POST['model'].'&verified='.$_POST['verify']),
				array('cms_to_list', $this_module->U_controller .'-my_list?cid='.$_POST['cid'].'&model='.$_POST['model']),
				array('cms_to_view', $this_module->controller .'-view-id-'.$id.'?verified='.$_POST['verify'], '_blank'),
				array('cms_to_add', $this_module->U_controller .'-add?cid='.$_POST['cid'].'&model='.$_POST['model'])
			),
			$this_module->U_controller .'-add?cid='.$_POST['cid'].'&model='.$_POST['model'],
			10000
		);
	}else{
		message($P8LANG['cms_item']['verify']['wait'], $this_module->U_controller .'-add?cid='.$_POST['cid'].'&model='.$_POST['model']);
	}
	
}