<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('rule') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	
	$page_url = $this_url .'?page=?page?';
	
	$select = select();
	$select->from($this_module->rule_table, 'id, name, cid, timestamp');
	$select->order('id DESC');
	if($cid){
		$select->in('cid', $cid);
		$page_url .= '&cid='. $cid;
		$select->order('timestamp DESC');
	}
	
	$count = 0;
	$page_size = 20;
	
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size
		)
	);
	
	$this_module->get_cache();
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($this_module, 'rule', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	
	switch($action){
	
	/** 导出 **/
	case 'export':
		$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$id or message('no_such_item');
		
		$ids = implode(',', $id);
		$query = $DB_master->query("SELECT id, name, cid, data FROM $this_module->rule_table WHERE id IN ($ids)");
		$data = array();
		while($v = $DB_master->fetch_array($query)){
			$v['cid'] = 0;
			unset($v['id']);
			$v['data'] = mb_unserialize($v['data']);
			$data[] = $v;
		}
		//转成gbk
		$data = convert_encode($core->CONFIG['page_charset'], 'gbk', $data);
		$content = serialize($data);
		
		header('Last-Modified: '. gmdate('D, d M Y H:i:s', P8_TIME).' GMT');
		header('Content-Type: text/plain');
		header('Pragma: no-cache');
		header('Content-Encoding: none');
		header('Content-Disposition: attachment; filename="rules.txt');
		header('Content-Length:'. strlen($content));
		
		exit($content);
	break;
	
	/** 导入 **/
	case 'import':
		$data = isset($_POST['data']) ? trim(p8_stripslashes2($_POST['data'])) : '';
		$data = convert_encode($core->CONFIG['page_charset'], 'gbk', $data);
		
		$data = @mb_unserialize($data);
		$data or message('fail');
		
		$data = convert_encode('gbk', $core->CONFIG['page_charset'], $data);
		
		foreach($data as $rule){
			unset($rule['id']);
			
			$this_module->add_rule($rule);
		}
		
		message('done');
	break;
	
	/** 解锁 **/
	case 'unlock':
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		
		$CACHE->delete('core/modules/'. $MODULE, 'task', $id);
		
		message('done');
	break;
	
	case 'rule_json':
		define('NO_ADMIN_LOG', true);
		
		$cid = isset($_POST['cid']) ? intval($_POST['cid']) : 0;
		
		$rules = $DB_master->fetch_all("SELECT id, name FROM $this_module->rule_table WHERE cid = '$cid'");
		
		exit(p8_json($rules));
	break;
	
	case '':
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$id or message('done');
		
		$DB_master->update(
			$this_module->rule_table,
			array('captured_items' => $DB_master->escape_string(serialize(array()))),
			"id = '$id'"
		);
		
		message('done');
	break;
	
	/** 删除 **/
	case 'delete':
		$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$id or exit('[]');
		
		$this_module->delete_rule(array(
			'where' => 'id IN ('. implode(',', $id) .')',
			'delete_item' => empty($_POST['delete_item']) ? false : true
		));
		
		exit(p8_json($id));
	break;
	
	}
	
}