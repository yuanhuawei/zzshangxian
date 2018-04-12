<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('') or message('no_privilege');

/**
* 还原
**/

if(REQUEST_METHOD == 'GET'){
	$job = isset($_GET['job']) ? $_GET['job'] : 'restore';
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

	@set_time_limit(0);
	
	$name = isset($_POST['name']) ? basename($_POST['name']) : '*';
	$name or message('access_denied');
	is_dir(CACHE_PATH .'db_backup/'. $name) or message('access_denied');
	
	if(!empty($_POST['delete'])){
		rm(CACHE_PATH .'db_backup/'. $name .'.zip');
		rm(CACHE_PATH .'db_backup/'. $name .'/');
		
		message('done', HTTP_REFERER, 60);
	}
	
	function _poster($msg = ''){
		global $this_url;
		
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
	
	if(empty($_POST['start'])){
		//初始化
		$files = glob(CACHE_PATH .'db_backup/'. $name .'/data_*.php');
		
		$_POST['start'] = 1;
		$_POST['offset'] = 0;
		$_POST['start_time'] = P8_TIME;
		$_POST['total'] = count($files);
		
		_poster($P8LANG['dbm_restore_init']);
	}
	
	
	
	$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
	if($offset >= $_POST['total']){
		//it's done
		message( p8lang($P8LANG['dbm_restore_done'], P8_TIME - $_POST['start_time']), $this_router .'-manage' );
	}
	
	define('NO_ADMIN_LOG', true);
	
	if($offset == 0){
		//struct
		$content = file_get_contents(CACHE_PATH .'db_backup/'. $name .'/data_'. $offset .'.php');
		$content = str_replace(";\r", ';', $content);
        foreach(explode(";\n", $content) as $v){
			$DB_master->query($v);
		}
	}else{
		//很快的啦
		$content = file_get_contents(CACHE_PATH .'db_backup/'. $name .'/data_'. $offset .'.php');
		$content = str_replace(";\r", ';', $content);
        foreach(explode(";\n", $content) as $v){
            $v = str_replace("\r\n", '\r\n', $v);
            $v = str_replace("\n", '\n', $v);
			$DB_master->query($v);
		}
	}
	
	$_POST['offset']++;
	
	_poster(p8lang($P8LANG['dbm_restore_process'], $_POST['total'], $_POST['offset']));
}