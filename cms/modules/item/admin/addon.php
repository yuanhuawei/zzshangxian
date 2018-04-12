<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('add') or message('no_privilege');

$this_system->init_model();

$this_model or message('no_such_cms_model');
$this_model['enabled'] or message('cms_model_disabled');

if(REQUEST_METHOD == 'GET'){
	$iid = isset($_GET['iid']) ? intval($_GET['iid']) : 0;
	$iid or message('no_such_item');
	
	if(isset($_GET['verified'])){
		$verified = $_GET['verified'] == 1 ? true : false;
	}else{
		$verified = true;
	}

	$select = select();
	if($verified){
		$select->from($this_module->table, 'id, cid, title, pages');
	}else{
		$select->from($this_module->unverified_table, 'id, cid, title, pages');
	}
	
	$select->in('id', $iid);
	$data = $core->select($select, array('single' => true, 'ms' => 'master'));
	$data or message('no_such_item');
	
	$data['iid'] = $data['id'];
	
	//检查权限
	if(!$this_controller->check_category_action('add', $data['cid'])){
		message('no_privilege');
	}
	
	require $this_model['path'] .'/admin/addon.php';
	
	$page_url = $this_router .'-update_addon?model='. $MODEL .'&iid='. $data['iid'] .'&verified='. $verified .'&page=?page?';
	
	$pages = list_page(array(
		'count' => $data['pages'],
		'page' => 1,
		'page_size' => 0,
		'url' => $page_url
	));
	
	$template = empty($this_model['CONFIG']['admin_edit_template']) ? 'edit' : $this_model['CONFIG']['admin_edit_template'];
	
	include template($this_module, $template, 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	require $this_model['path'] .'/admin/addon.php';
	
	$ADMIN_LOG = array('title' => $P8LANG['_module_addon_admin_log']);
	
	//分页
	$content = array();
	if(isset($_POST['field#']['content'])){
		$content = preg_split('#<div style="page-break-after:\s*?always;">\s*?<span style="display: none;">.*?</span>\s*?</div>#is', $_POST['field#']['content']);
		
		$_POST['field#']['content'] = array_shift($content);
	}
	
	$this_controller->addon($_POST) or message('fail');
	
	foreach($content as $v){
		$_POST['field#']['content'] = $v;
		
		$this_controller->addon($_POST);
	}
	
	message('done', HTTP_REFERER);
}