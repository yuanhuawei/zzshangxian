<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('ad') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id']) ? $_GET['id'] : '';
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max($page, 1);

	$select = select();
	$select->from($this_module->table .' AS a', 'a.*');

	$page_url = $this_url .'?page=?page?';

	if($keyword){
		$select->like('name', $keyword);
		$page_url .= '&keyword='. urlencode($keyword);
	}
	if($id){
		$select->in('id', $id);
		$page_url .= '&id='. $id;
	}

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$count = 0;


	$select->order('id DESC');

	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);

	foreach($list as $k => $v){
		
		$file = $this_module->js_file($v['id']);
		
		$list[$k]['preview_url'] = $this_module->url .'/js/'. $file .'.php';
		
		$list[$k]['invoke'] = html_entities('<script type="text/javascript" src="'. $this_module->url .'/js/'. $file .'.js.php"></script>|'.
			'<script type="text/javascript" src="{$core.modules[\''. $MODULE .'\'][\'url\']}/js/'. $file .'.js.php"></script>|'.
			'<iframe scrolling="no" frameborder="no" width="'. $v['width'] .'" height="'. $v['height'] .'" src="'. $this_module->url .'/js/'. $file .'.php" border="0" marginwidth="0" marginheight="0"></iframe>|'.
			'<iframe scrolling="no" frameborder="no" width="'. $v['width'] .'" height="'. $v['height'] .'" src="{$core.modules[\''. $MODULE .'\'][\'url\']}/js/'. $file .'.php" border="0" marginwidth="0" marginheight="0" /></iframe>|'.
			$P8LANG['ad_invoke_note']
		);
		
		$list[$k]['type'] = 'ad_type_'. $v['type'];
	}

	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $page_url
	));

	include template($this_module, 'list', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$action = @$_POST['action'];
	
	switch($action){
	
	case 'statistic':
		
		$DB_master->update(
			$this_module->table,
			array('buy_count' => 0),
			''
		);
		
		$query = $DB_master->query("SELECT aid, COUNT(*) AS `count` FROM $this_module->buy_table GROUP BY aid");
		while($arr = $DB_master->fetch_array($query)){
			$DB_master->update(
				$this_module->table,
				array('buy_count' => $arr['count']),
				"id = '$arr[aid]'"
			);
		}
		
		message('done');
		
	break;
	
	}
	
}