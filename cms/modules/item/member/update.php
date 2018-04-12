<?php
defined('PHP168_PATH') or die();

/**
* 更新模型内容入口文件
**/

$this_system->init_model();
$this_model or message('no_such_cms_model');
$this_model['enabled'] or message('cms_model_disabled');

if(REQUEST_METHOD == 'GET'){
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');

	if(isset($_GET['verified'])){
		$verified = $_GET['verified'] == 1 ? true : false;
	}else{
		$verified = true;
	}

	if($verified){
		
		$select = select();
		$select->from($this_module->main_table .' AS m', 'm.*');
		$select->inner_join($this_module->addon_table .' AS a', 'a.*', 'm.id = a.iid');
		$select->inner_join($this_module->table .' AS i', 'i.*', 'i.id = m.id');
		$select->in('i.id', $id);
		$select->in('a.page', 1);
		$data = $core->select($select, array('single' => true));
		$data or message('no_such_item');
		
	}else{
		
		$select = select();
		$select->from($this_module->unverified_table, 'data');
		$select->in('id', $id);
		$_data = $core->select($select, array('single' => true));
		$_data or message('no_such_item');
		
		$_data = mb_unserialize($_data['data']);
		$data = array_merge($_data['addon'], $_data['item'], $_data['main']);
		
	}
	//检查分类权限
	if($data['uid'] != $UID){
		$this_controller->check_category_action('update', $data['cid']) or message($P8LANG['cms_item']['no_category_privilege']);
	}
	$this_module->format_data($data);

	//内容属性
	$data['attributes'] = array_flip(explode(',', $data['attributes']));
	$data['summary'] = html_entity_decode($data['summary']);
	$allow_create_time = $this_controller->check_action('create_time');
	$allow_attribute = $this_controller->check_action('attribute');
	
	$select = select();
	$select->from($this_module->attribute_table. ' AS a', 'a.aid, a.timestamp, a.last_setter');
	$select->in('a.id', $id);
	$_attributes = $core->list_item(
		$select,
		array(
			'page' => 0
		)
	);
	$attributes = array();
	foreach($_attributes as $v){
		$attributes[$v['aid']] = $v;
	}
	unset($_attributes);
	$my_addible_category = p8_json($this_controller->get_acl('my_addible_category'));
	
	require $this_model['path'] .'/member/update.php';
	
	$template = empty($this_model['CONFIG']['member_edit_template']) ? 'edit' : $this_model['CONFIG']['member_edit_template'];
	
	include template($this_module, $template);
	
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	if(!$this_controller->check_admin_action('verify')){
		unset($_POST['verify']);
	}
	
	if(isset($_POST['verified'])){
		$verified = $_POST['verified'] == 1 ? true : false;
	}else{
		$verified = true;
	}
	
	$_POST['verify'] = $this_controller->check_category_action('autoverify', $_POST['cid']) ? 1 : 0;
	
	require $this_model['path'] .'member/update.php';
	
	$this_controller->update($id, $_POST, $verified) or message('fail');
	if(!$_POST['verify']){
		message($P8LANG['cms_item']['verify']['wait_again'], $this_module->U_controller .'-add?cid='.$_POST['cid'].'&model='.$_POST['model']);
	}else{
	message(
		array(
			array('cms_to_edit', $this_module->U_controller .'-update?id='.$id.'&model='.$_POST['model'].'&verified='.$verified),
			array('cms_to_list', $this_module->U_controller .'-my_list?cid='.$_POST['cid'].'&model='.$_POST['model']),
			array('cms_to_view', $this_module->controller .'-view-id-'.$id.'?verified='.$verified, '_blank'),
			array('cms_to_add', $this_module->U_controller .'-add?cid='.$_POST['cid'].'&model='.$_POST['model'])
		),
		$this_module->U_controller .'-add?cid='. $_POST['cid'] .'&model='. $_POST['model'],
		10000
	);
	}
	
}