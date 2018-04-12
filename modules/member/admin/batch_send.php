<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	parse_str(isset($_GET['where']) ? $_GET['where'] : '', $GET);
	//JS传过来的,UTF-8解码
	$GET = from_utf8($GET);
	
	include template($this_module, 'batch_send', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$hash = isset($_POST['hash']) ? preg_replace('/[^0-9a-zA-Z]/', '', $_POST['hash']) : '';
	
	if(empty($hash)){
		//初始化
		
		$where = '1 ';
		
		$ids = isset($_POST['id']) ? filter_int(explode(',', $_POST['id'])) : array();
		if($ids){
			
			//选定的
			$where .= ' AND id IN ('. implode(',', $ids) .')';
			
		}else{
			
			$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
			if($role_id){
				$where .= " AND role_id = '$role_id'";
			}else{
				$role_gid = isset($_POST['role_gid']) ? intval($_POST['role_gid']) : 0;
				if($role_gid){
					$where .= " AND role_gid = '$role_gid'";
				}
			}
			
			if(!empty($_POST['is_admin'])){
				$where .= " AND is_admin = '1'";
			}
			
			$keyword = isset($_POST['keyword']) ? html_entities(trim($_POST['keyword'])) : '';
			if($keyword){
				$where .= " AND username LIKE '%$keyword%'";
			}
		}
		
		$title = isset($_POST['title']) ? html_entities($_POST['title']) : '';
		$acl = $core->load_acl('core', '', $core->ROLE);
		$content = isset($_POST['content']) ? p8_html_filter($_POST['content'], $acl['allow_tags'], $acl['disallow_tags']) : '';
		
		$ret = $DB_slave->fetch_one("SELECT COUNT(*) AS num FROM $this_module->table WHERE $where");
		if($ret['num'] == 0){
			message('no_user_selected');
		}
		$perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 50;
		$perpage = max($perpage, 1);
		$pages = ceil($ret['num'] / $perpage);
		
		$hash = unique_id(16);
		
		$config = array(
			'where' => $where,
			'offset' => 0,
			'perpage' => $perpage,
			'total' => (int)$ret['num'],
			'pages' => $pages,
			'title' => $title,
			'content' => $content,
			'email' => empty($_POST['email']) ? false : true,
			'pm' => empty($_POST['pm']) ? false : true,
			'sms' => empty($_POST['sms']) ? false : true,
		);
		$CACHE->write('core/modules', 'member', 'batch_send_'. $hash, $config, 'serialize');
		
		$message = p8lang($P8LANG['batch_send_note'], $ret['num']);
		
		echo <<<EOT
<html>
<body>
<form action="$this_url" method="post" id="form">
<input type="hidden" name="hash" value="$hash" />
<input type="hidden" name="cancel" value="0" />
</form>
<script type="text/javascript">
if(confirm('$message')){
	document.getElementById('form').submit();
}else{
	document.getElementById('form').cancel.value = 1;
	document.getElementById('form').submit();
}
</script>
</body>
</html>
EOT;
		exit;
	}
	//初始化完成


	if(!empty($_POST['cancel'])){
		//取消
		$CACHE->delete('core/modules', 'member', 'batch_send_'. $hash);
		
		echo '<html><body><script type="text/javascript">window.close();</script></body></html>';
		exit;
	}




	
	
	
	
	
	
	
	
	
	define('NO_ADMIN_LOG', true);
	//读取任务配置
	$config = $CACHE->read('core/modules', 'member', 'batch_send_'. $hash, 'serialize');
	
	if($config['offset'] >= $config['pages']){
		//已经完成了-----------------------------------------------------------------------
		$CACHE->delete('core/modules', 'member', 'batch_send_'. $hash, 'serialize');
		message('done', $core->admin_controller .'/core/member-list');
	}
	
	if($config['email']){
		$mailer = &$core->load_module('mail');
	}
	
	if($config['pm']){
		$pm = &$core->load_module('message');
	}
	
	if($config['sms']){
		$sms = &$core->load_module('sms');
	}
	
	$offset = $config['offset'] * $config['perpage'];
	$query = $DB_slave->query("SELECT email, cell_phone, id, username, name FROM $this_module->table
	WHERE $config[where]
	LIMIT $offset, $config[perpage]");
	
	while($arr = $DB_slave->fetch_array($query)){
		
		$content = str_replace(
			array('{$uid}', '{$username}', '{$name}'),
			array($arr['id'], $arr['username'], $arr['name']),
			$config['content']
		);
		
		if($config['email']){
			$mailer->set(array(
				'subject' => $config['title'],
				'message' => $content,
				'send_to' => $arr['email']
			));
			$mailer->send();
		}
		
		if($config['pm']){
			$m = array(
				'uid' => $arr['id'],
				'title' => $config['title'],
				'content' => $content,
				'system' => true,
			);
			$pm->send($m);
		}
		
		if($config['sms']){
			$sms->send($arr['cell_phone'], $content);
		}
	}
	
	//准备下一轮
	$config['offset']++;
	$CACHE->write('core/modules', 'member', 'batch_send_'. $hash, $config, 'serialize');
	
	echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$core->CONFIG['page_charset']}" />
</head>
<body>
$offset / $config[pages]
<form action="$this_url" method="post" id="form">
<input type="hidden" name="hash" value="$hash" />
</form>
<script type="text/javascript">
setTimeout(function(){document.getElementById('form').submit()}, 100);
</script>
</body>
</html>
EOT;
exit;
}