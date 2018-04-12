<?php
defined('PHP168_PATH') or die();

/**
* 修改分类
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_message');
	$data['type']=isset($_GET['type']) ? $_GET['type'] : 1;
	$select = select();
	$select->from($this_module->table, '*');
	$select->in('id', $id);
	$data = $core->select($select, array('single' => true, 'ms' => 'master'));
	$config = mb_unserialize($data['config']);
	$config['allow_ip']['enabled'] = isset($config['allow_ip']['enabled']) ? ($config['allow_ip']['enabled'] == 1 ? 1 : 0) : 0;
	$config['allow_ip']['collectip'] = isset($config['allow_ip']['collectip']) ? $config['allow_ip']['collectip'] : array();
	$config['allow_ip']['beginip'] = isset($config['allow_ip']['beginip']) ? trim($config['allow_ip']['beginip']) : '';
	$config['allow_ip']['endip'] = isset($config['allow_ip']['endip']) ? trim($config['allow_ip']['endip']) : '';
	$config['allow_ip']['ruleoutip'] = isset($config['allow_ip']['ruleoutip']) ? $config['allow_ip']['ruleoutip'] : array();
	$core->get_cache('role');
	//$config['administrator'] = implode(',', array_keys($config['administrator']));
	
	$data or message('no_such_cms_category');
	
	$data['frame'] && $data['frame'] = attachment_url($data['frame']);
	
	$MODEL = '';
	$models = $this_system->get_models();
	$model = $this_system->get_model($data['model']);
	
	$order_fields = array(
		'list_order' => $P8LANG['cms_category_order_by_default'],
		'timestamp' => $P8LANG['cms_category_order_by_timestamp'],
		'views' => $P8LANG['cms_category_order_by_views'],
		'comments' => $P8LANG['cms_category_order_by_comments'],
	);
	
	if(!empty($model['filterable_fields'])){
		foreach($model['filterable_fields'] as $name => $v){
			$order_fields[$name] = $v['alias'];
		}
	}
	
	load_language($core, 'config');
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){

	//提交到iframe的
	
	$_POST = p8_stripslashes2($_POST);
	
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$this_controller->update($id, $_POST);
	//print_r($_POST);exit;
	if(P8_AJAX_REQUEST){
		//关闭窗口
		exit('<script type="text/javascript">alert("'. $P8LANG['done'] .'");document.domain = \''. $core->CONFIG['base_domain'] .'\';parent.edit_dialog.close();</script>');
	}else{
		message('done');
	}
}