<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('') or message('no_privilege');

if(REQUEST_METHOD == 'POST'){

function _poster($msg = ''){
	global $this_url, $P8LANG;
	
	$fields = '';
	foreach($_POST as $k => $v){
		$fields .= '<input type="hidden" name="'. $k .'" value="'. $v .'" />';
	}
	
	$form = <<<EOT
$msg
<form action="$this_url" method="post" id="form">
$fields
</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById('form').submit(); }, 1);
</script>
EOT;
	message($form);
}



if(empty($_POST['tid'])){
	
	//锁定中
	if($CACHE->read($SYSTEM .'/modules/', $MODULE, 'backup_lock', 'serialize')){
		message('dbm_backup_locked');
	}
	
	//初始化
	$tables = $this_module->table_status();
	
	$tid = unique_id(16);
	$charset = !empty($_POST['charset']) ? basename($_POST['charset']) : $core->CONFIG['page_charset'];
	if(isset($_POST['rows'])){
		$rows = intval($_POST['rows']);
		$rows = max(1, $rows);
	}else{
		$rows = 50;
	}
	
	$table_prefix = $afx = '';
	if($_POST['ours']==1){
		$table_prefix = $core->CONFIG['table_prefix'];
		$afx = '_ours';
	}elseif($_POST['ours']==2){
		$site = &$core->load_system('sites');
		$table_prefix = $site->TABLE_;	
		$afx = '_main';
	}	
	
	$task = array(
		'start_time' => P8_TIME,
		'offset' => 0,
		'table_offset' => 0,
		'file_offset' => 1,
		'rows' => $rows,
		'prefix' => isset($_POST['prefix']) ? basename($_POST['prefix']) : '',
		'charset' => $charset,
		'path' => 'db_backup/'. date('Y-m-d#H_i', P8_TIME).$afx. '('. $charset .')',
		'tables' => array()
	);
	
	$_POST['tid'] = $tid;
	
	$sql = "-- <?php exit;?>\r\n";
	foreach($tables as $v){
		if($_POST['ours']==1 && strpos($v['Name'], $table_prefix)!==0){
			continue;
		}elseif($_POST['ours']==2 && strpos($v['Name'], $table_prefix)===0){
			continue;
		}
		$data = $DB_master->fetch_one("SHOW CREATE TABLE `$v[Name]`");
		if(!empty($task['charset']) && $task['charset'] != $core->CONFIG['page_charset']){
			$data['Create Table'] = preg_replace(
				'/DEFAULT\s+CHARSET=.+/i',
				'DEFAULT CHARSET='. (strtolower($charset) == 'utf-8' ? 'utf8' : $charset),
				$data['Create Table']
			);
		}
		
		if(
			$v['Name'] == $core->CONFIG['table_prefix'] .'session' ||
			$v['Name'] == $core->CONFIG['table_prefix'] .'pagecache'
		){
			//session, pagecache 表不管
			
			$sql .= preg_replace('/^CREATE TABLE/i', 'CREATE TABLE IF NOT EXISTS', $data['Create Table']) .";\r\n\r\n";
			
		}else{
			$sql .= "DROP TABLE IF EXISTS `$v[Name]`;\r\n";
			$sql .= $data['Create Table'] .";\r\n\r\n";
			
			$task['tables'][$v['Name']] = $v['Rows'];
		}
		
	}
	
	md(CACHE_PATH . $task['path']);
	write_file(CACHE_PATH . $task['path'] .'/data_0.php', $sql);
	
	$CACHE->write($SYSTEM .'/modules/'. $MODULE, 'task', $tid, $task, 'serialize');
	
	//加锁
	$CACHE->write($SYSTEM .'/modules/', $MODULE, 'backup_lock', $tid, 'serialize');
	
	_poster( p8lang($P8LANG['dbm_backup_init'], count($task['tables'])) );
}


define('NO_ADMIN_LOG', true);

$tid = basename(isset($_POST['tid']) ? $_POST['tid'] : '');
$task = $CACHE->read($SYSTEM .'/modules/'. $MODULE, 'task', $tid, 'serialize');
$task or message('access_denied', $this_router .'-manage');

@set_time_limit(0);
ignore_user_abort(false);

$current = each($task['tables']);

if(empty($current)){
	//it's done
	$CACHE->delete($SYSTEM .'/modules/'. $MODULE, 'task', $tid);
	
	//解锁
	$CACHE->delete($SYSTEM .'/modules/', $MODULE, 'backup_lock');
	
	if(!empty($task['compress'])){
		//压缩
		require_once PHP168_PATH .'zip.class.php';
		$zip = new zip_file(CACHE_PATH . $task['path'] .'.zip');
		$zip->set_options(array('basedir' => CACHE_PATH .'db_backup/', 'overwrite' => 1, 'level' => 1));
		$zip->add_files(basename($task['path']));
		$zip->create_archive();
	}
	
	message(p8lang($P8LANG['dbm_backup_done'], P8_TIME - $task['start_time']), $this_router .'-manage', 60);
}

$param = array(
	'rows' => $task['rows'],
	'charset' => $task['charset'],
	'prefix' => $task['prefix']
);
if(isset($task['last_max'])){
	$param['last_max'] = $task['last_max'];
}

//需要order by 主键作为偏移
$primaries = include $this_module->path .'backup_primary.php';

$sql = '';
//less than 1M
while(strlen($sql) < 1048576){
	
	if($is_primary = isset($primaries[$current['key']])){
		$param['primary'] = $task['primary'] = $primaries[$current['key']];
	}
	
	$param['offset'] = $task['table_offset'] * $task['rows'];
	$data = $this_module->backup($current['key'], $param);
	
	if($data['sql']){
		$sql .= $data['sql'];
		if($is_primary && isset($data['last_max'])){
			$task['last_max'] = $param['last_max'] = $data['last_max'];
		}
		
		//continue
		$task['table_offset']++;
	}else{
		unset($param['primary'], $param['last_max'], $task['last_max']);
		$param['table_offset'] = $task['table_offset'] = 0;
		
		//完成一个表,弹出
		array_shift($task['tables']);
		$current = each($task['tables']);
		
		//done
		if(empty($current)){
			break;
		}
	}
	
}

//写文件
write_file(CACHE_PATH . $task['path'] .'/data_'. $task['file_offset']++ .'.php', "-- <?php exit;?>\r\n". $sql);

$CACHE->write($SYSTEM .'/modules/'. $MODULE, 'task', $tid, $task, 'serialize');

_poster(
	p8lang(
		$P8LANG['dbm_backup_process'],
		count($task['tables']),
		$current['key'] . $data['_sql'],
		$task['table_offset'] * $task['rows'],
		$current['value']
	)
);

}