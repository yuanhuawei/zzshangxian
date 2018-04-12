<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$ttl = $last_update = array(null, null);
	$system = isset($_GET['system']) ? html_entities($_GET['system']) : '';
	$module = isset($_GET['module']) ? html_entities($_GET['module']) : '';
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$site = isset($_GET['site']) ? $_GET['site'] : '';
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
	$postfix = isset($_GET['postfix']) ? preg_replace('/[^0-9a-zA-Z_]/', '', $_GET['postfix']) : '';
	$sitesd = isset($core->systems['sites']) && $core->systems['sites']['installed']; 
	$all = empty($_GET['all']) ? 0 : 1;
	
	if($system && $system != 'core' && !isset($core->systems[$system])){
		message('no_such_system');
	}
	
	$systems = $core->systems;
	$modules = get_modules($system);
	
	$select = select();
	$select->from($this_module->table .' AS l', 'id, system, module, name, type, variable, postfix, timestamp, last_update, ttl, invoke, site');
	
	$select->order('id DESC');
	
	$page_url = $this_url .'?all='. $all;
	
	if(isset($_GET['ttl'][0]) && strlen($_GET['ttl'][0])){
		$ttl[0] = intval($_GET['ttl'][0]);
		$page_url .= '&ttl[0]='. $ttl[0];
	}
	if(isset($_GET['ttl'][1]) && strlen($_GET['ttl'][1])){
		$ttl[1] = intval(max(1, $_GET['ttl'][1]));
		$page_url .= '&ttl[1]='. $ttl[1];
	}
	
	if(isset($_GET['last_update'][0]) && strlen($_GET['last_update'][0]) && ($time = strtotime($_GET['last_update'][0]))){
		$last_update[0] = $time;
		$page_url .= '&last_update[0]='. $_GET['last_update'][0];
	}
	if(isset($_GET['last_update'][1]) && strlen($_GET['last_update'][1]) && ($time = strtotime($_GET['last_update'][1]))){
		$last_update[1] = $time;
		$page_url .= '&last_update[1]='. $_GET['last_update'][1];
	}
	
	if($system){
		$select->in('system', $system);
		$page_url .= '&system='. $system;
	}

	if($module){
		$select->in('module', $module);
		$page_url .= '&module='. $module;
	}

	if($keyword){
		$select->like('name', html_entities($keyword));
		$page_url .= '&keyword='. urlencode($keyword);
	}
	if($site){
		$select->in('site', html_entities($site));
		$page_url .= '&site='. urlencode($site);
	}
	if($id){
		$select->in('id', $id);
		$page_url .= '&id='. $id;
	}	
	if($postfix){
		$select->in('postfix', $postfix);
		$page_url .= '&postfix='. urlencode($postfix);
	}

	if($ttl[0] !== null || $ttl[1] !== null){
		$select->range('ttl', $ttl[0], $ttl[1]);
	}
	
	if($last_update[0] !== null || $last_update[1] !== null){
		$select->range('last_update', $last_update[0], $last_update[1]);
		$select->order('l.last_update ASC');
		
		$last_update[0] = @$_GET['last_update'][0];
		$last_update[1] = @$_GET['last_update'][1];
	}

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$count = 0;
	$page_size = 40;
	
	$page_url .= '&page=?page?';
	
	//echo $select->build_sql();
	
	if(empty($_GET['search']) && !empty($_GET['exportall'])){
		$query = $DB_master->query($select->build_sql());
		$data = array();
		while($arr = $DB_master->fetch_array($query)){
			$arr['option'] = mb_unserialize($arr['option']);
			unset($arr['id']);
			unset($arr['timestamp']);
			unset($arr['last_update']);
			$data[] = $arr;
		}
		//转成GBK
		$data = convert_encode($core->CONFIG['page_charset'], 'gbk', $data);
		
		$content = serialize($data);
		header('Last-Modified: '. gmdate('D, d M Y H:i:s', P8_TIME).' GMT');
		header('Content-Type:application/octet-stream');
		header('Pragma: no-cache');
		header('Content-Encoding: none');
		header('Content-Disposition: attachment; filename="label.txt');
		header('Content-Length:'. strlen($content));
		
		exit($content);
	}

	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size
		)
	);

	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));

	include template($this_module, 'list', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$action = isset($_POST['act']) ? $_POST['act'] : '';
	
	switch($action){
	
	case 'import':
		$data = isset($_POST['data']) ? trim(p8_stripslashes2($_POST['data'])) : '';
		$data = convert_encode($core->CONFIG['page_charset'], 'gbk', $data);
		
		$data = @mb_unserialize($data);
		$data or message('fail', HTTP_REFERER);
		
		//转成GBK
		$data = convert_encode('gbk', $core->CONFIG['page_charset'], $data);
		
		foreach($data as $label){
			unset($label['id']);
			
			$this_module->add($label,true);
		}
		
		message('done', HTTP_REFERER);
	break;
	
	case 'export':
		define('NO_ADMIN_LOG', true);
		
		$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$id or exit('no_such_item');
		
		$ids = implode(',', $id);
		$query = $DB_master->query("SELECT * FROM $this_module->table WHERE id IN ($ids)");
		$data = array();
		while($arr = $DB_master->fetch_array($query)){
			$arr['option'] = mb_unserialize($arr['option']);
			unset($arr['id']);
			unset($arr['timestamp']);
			unset($arr['last_update']);
			$data[] = $arr;
		}
		//转成GBK
		$data = convert_encode($core->CONFIG['page_charset'], 'gbk', $data);
		
		$content = serialize($data);
		header('Last-Modified: '. gmdate('D, d M Y H:i:s', P8_TIME).' GMT');
		header('Content-Type:application/octet-stream');
		header('Pragma: no-cache');
		header('Content-Encoding: none');
		header('Content-Disposition: attachment; filename="label.txt');
		header('Content-Length:'. strlen($content));
		
		exit($content);
	break;
	
	}
}