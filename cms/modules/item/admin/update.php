<?php
defined('PHP168_PATH') or die();

/**
* 修改内容
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$this_system->init_model();
$this_model or message('no_such_cms_model');
$this_model['enabled'] or message('cms_model_disabled');

$allow_verify = $this_controller->check_admin_action('verify');
$allow_attribute = $this_controller->check_admin_action('attribute');
$allow_list_order = $this_controller->check_admin_action('list_order');
$allow_create_time = $this_controller->check_admin_action('create_time');
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
		$select->inner_join($this_module->table .' AS i', 'i.*', 'i.id = m.id');
		$select->inner_join($this_module->addon_table .' AS a', 'a.*, a.iid AS id', 'm.id = a.iid');
		$select->in('i.id', $id);
		$select->in('a.page', 1);
		
		$data = $core->select($select, array('single' => true, 'ms' => 'master'));
		$data or message('no_such_item');
		
	}else{
		
		$select = select();
		$select->from($this_module->unverified_table, 'verified, pages, data');
		$select->in('id', $id);
		$_data = $core->select($select, array('single' => true, 'ms' => 'master'));
		$_data or message('no_such_item');
		
		$verified = $_data['verified'];
		$pages = $_data['pages'];
		$_data = mb_unserialize($_data['data']);
		$data = array_merge($_data['addon'], $_data['item'], $_data['main']);
		$data['pages'] = $pages;
		$data['verified'] = $verified;
		unset($_data);
		//print_r($_data);
	}
	//echo $select->build_sql();
	
	//检查权限
	if($data['uid'] != $UID){
		$this_controller->check_category_action('update', $data['cid']) or message($P8LANG['cms_item']['no_category_privilege']);
	}
	
	$my_addible_category = p8_json($this_controller->get_acl('my_addible_category'));
	
	
	$this_module->format_data($data);
	$data['list_order_date'] = date('Y-m-d H:i:s', $data['list_order']);
	$data['timestamp_date'] = date('Y-m-d H:i:s', $data['timestamp']);
	
	//内容属性
	$data['attributes'] = array_flip(explode(',', $data['attributes']));
	$data['summary'] = html_entity_decode($data['summary']);

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
	
	$data['iid'] = $data['id'];
	$page_url = $this_router .'-update_addon?model='. $MODEL .'&iid='. $data['id'] .'&verified='. $verified .'&page=?page?';
	
	$pages = list_page(array(
		'count' => $data['pages'],
		'page' => 1,
		'page_size' => 0,
		'url' => $page_url
	));
	
	
	require $this_model['path'] .'/admin/update.php';
	
	$assist_category = $this_system->load_module('assist_category');
	$assist_categories = $assist_category->get_sids($id);
	
	$template = empty($this_model['CONFIG']['admin_edit_template']) ? 'edit' : $this_model['CONFIG']['admin_edit_template'];
	
	include template($this_module, $template, 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	if(!$this_controller->check_admin_action('verify')){
		unset($_POST['verify']);
	}
	$_POST['verify'] = $this_controller->check_category_action('autoverify', $_POST['cid']) ? 1 : 0;
	if(isset($_POST['verified'])){
		$verified = $_POST['verified'] == 1 ? true : false;
	}else{
		$verified = true;
	}
	
	require $this_model['path'] .'/admin/update.php';
	
	$ADMIN_LOG = array('title' => $P8LANG['_module_update_admin_log']);
	
	$this_controller->update($id, $_POST, $verified) or message('fail');
	
	message(
		array(
			array('cms_to_edit', $this_module->admin_controller .'-update?id='.$id.'&model='.$_POST['model'].'&verified='. $verified),
			array('cms_to_list', $this_module->admin_controller .'-list?cid='.$_POST['cid'].'&model='.$_POST['model']),
			array('cms_to_view', $this_module->controller .'-view-id-'. $id .'?verified='. $verified, '_blank'),
			array('cms_to_add', $this_module->admin_controller .'-add?cid='.$_POST['cid'].'&model='.$_POST['model'])
		),
		$this_module->admin_controller .'-add?cid='. $_POST['cid'] .'&model='. $_POST['model'],
		10000
	);
	
}