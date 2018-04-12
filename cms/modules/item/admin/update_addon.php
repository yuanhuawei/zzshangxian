<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('update') or message('no_privilege');

$this_system->init_model();
$this_model or message('no_such_cms_model');
$this_model['enabled'] or message('cms_model_disabled');

if(REQUEST_METHOD == 'GET'){
	//内容ID
	$iid = isset($_GET['iid']) ? intval($_GET['iid']) : 0;
	$iid or message('no_such_item');
	
	//追加内容ID
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max($page, 1);
	
	if(isset($_GET['verified'])){
		$verified = $_GET['verified'] == 1 ? true : false;
	}else{
		$verified = true;
	}
	
	if($page == 1){
		header('Location: '. $this_router .'-update?model='. $MODEL .'&id='. $iid .'&verified='. $verified);
		exit;
	}
	
	$select = select();
	if($verified){
		$select->from($this_module->table .' AS i', 'i.*');
	}else{
		$select->from($this_module->unverified_table .' AS i', 'i.*');
	}
	
	$select->inner_join($this_module->addon_table .' AS a', 'a.*', 'i.id = a.iid');
	//附加表的ID覆盖主表的ID
	$select->in('i.id', $iid);
	if($id){
		$select->in('a.id', $id);
	}else{
		if($verified){
			$select->order('a.page ASC');
			$select->limit($page -1, 1);
		}else{
			if($page != 1){
				$select->order('a.page ASC');
				$select->limit($page -2, 1);
			}
		}
	}
	
	//echo $select->build_sql();
	$data = $core->select($select, array('single' => true, 'ms' => 'master'));
	$data or message('no_such_item');
	
	//检查权限
	if($data['uid'] != $UID){
		$this_controller->check_category_action('update', $data['cid']) or message('no_privilege');
	}
	
	if(!$verified && $page == 1){
		$data['data'] = mb_unserialize($data['data']);
		$data = array_merge($data['data']['addon'], $data['data']['item'], $data['data']['main']);
	}
	
	$page_url = $this_router .'-update_addon?model='. $MODEL .'&iid='. $data['iid'] .'&verified='. $verified .'&page=?page?';
	
	$pages = list_page(array(
		'count' => $data['pages'],
		'page' => $page,
		'page_size' => 0,
		'url' => $page_url
	));
	
	$this_module->format_data($data);
	
	require $this_model['path'] .'/admin/update_addon.php';
	
	$template = empty($this_model['CONFIG']['admin_edit_template']) ? 'edit' : $this_model['CONFIG']['admin_edit_template'];
	
	include template($this_module, $template, 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	require $this_model['path'] .'/admin/update_addon.php';
	
	$this_controller->update_addon($_POST);
	
	message('done', HTTP_REFERER);
}