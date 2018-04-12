<?php
defined('PHP168_PATH') or die();

/**
* 表管理
**/

$this_controller->check_admin_action('') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$job = isset($_GET['job']) ? $_GET['job'] : 'backup';
	$sitesd = isset($core->systems['sites']) && $core->systems['sites']['installed']; 
	switch($job){
		case 'restore':
			$list = array();
			$handle = opendir(CACHE_PATH .'db_backup/');
			while(($item = readdir($handle)) !== false){
				if($item == '.' || $item == '..' || !is_dir(CACHE_PATH .'db_backup/'. $item)) continue;
				
				$list[] = $item;
			}
		break;
		case 'optimize': case 'backup':
			$list = $this_module->table_status();
			$info = include $this_module->path .'#.php';
			
			$size = 0;
			foreach($list as $k => $v){
				$a = str_replace($core->CONFIG['table_prefix'], '', $v['Name']);
				$list[$k]['alias'] = isset($info['table_alias'][$a]) ? $info['table_alias'][$a] : '';
				
				$size += $v['Data_length'];
			}
		break;
		case 'query':
		
		break;
	
	}
	include template($this_module, 'list', 'admin');

	
}else if(REQUEST_METHOD == 'POST'){
	
	$action = isset($_POST['act']) ? $_POST['act'] : '';
	$tables = isset($_POST['name']) ? (array)$_POST['name'] : array();
	foreach($tables as $k => $v){
		if( !( $v = trim($this_controller->valid_table_name(basename($v))) ) ){
			unset($tables[$k]);
			continue;
		}
		
		$tables[$k] = $v;
	}
	
	switch($action){
	
	case 'optimize':
		$this_module->optimize_table($tables);
	break;
	
	case 'repair':
		$this_module->repair_table($tables);
	break;
	
	case 'drop':
		$this_module->drop_table($tables);
	break;
	
	case 'truncate':
		$this_module->truncate_table($tables);
	break;
	
	case 'unlock':
		//解锁
		$tid = $CACHE->read($SYSTEM .'/modules/', $MODULE, 'backup_lock','serialize');
		$CACHE->delete($SYSTEM .'/modules/'. $MODULE, 'task', $tid);
		$CACHE->delete($SYSTEM .'/modules/', $MODULE, 'backup_lock');
	break;
	
	case 'sql':
		$sql = isset($_POST['sql']) ? p8_stripslashes2($_POST['sql']) : '';
		$sql = preg_replace('!--[^\r\n]*|#[^\r\n]*|/\*[\s\S]*\*/!', '', $sql);
		//危险的,你懂的
		if(!preg_match('/^select|update|alter|delete/i', $sql) || preg_match('/into\s+outfile/i', $sql)) message('access_denied');
		if(preg_match('/alter|delete/i', $sql) && !$IS_FOUNDER) message('access_denied');
		if(preg_match('/update|delete/i', $sql) && !preg_match('/where/i', $sql)) message('access_denied');
		
		$list = $DB_master->fetch_all($sql);
		$fields = array();
		foreach($list as $v){
			foreach($v as $field => $vv) $fields[] = $field;
			break;
		}
		
		include template($this_module, 'sql', 'admin');
		exit;
	break;
	
	}
	
	message('done', HTTP_REFERER);
	
}