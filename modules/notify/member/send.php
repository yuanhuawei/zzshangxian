<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $this_module->view($id);
	$data or message('no_such_item');
	
	$select = select();
	$select->from($this_module->sign_in_table .' AS s', 's.*');
	$select->inner_join($core->member_table .' AS m', 'm.username', 's.uid = m.id');
	$select->in('nid', $id);
	$select->order('s.status DESC');
	
	$list = $core->list_item(
		$select,
		array(
			'page' => 0
		)
	);
	
	include template($this_module, 'send');
	
}else if(REQUEST_METHOD == 'POST'){
	
	
	
	
	
	
	
	
	

function _poster($hash, $message = ''){
	global $this_url;
	
	echo <<<EOT
<html>
<body>
$message
<form action="$this_url" method="post" id="form">
<input type="hidden" name="hash" value="$hash" />
</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById('form').submit(); }, 1);
</script>
</body>
</html>
EOT;
	exit;
}

$hash = isset($_POST['hash']) ? preg_replace('/[^0-9a-zA-Z]/', '', $_POST['hash']) : '';

//初始化任务
if(empty($hash)){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$data = $this_module->view($id);
	$data or message('no_such_item');
	
	$usernames = $comma = '';
	foreach(explode(',', $data['data']) as $v){
		if($v == '') continue;
		
		$v = explode('(', $v);
		if($v[0] == '') continue;
		
		$usernames .= $comma . "'$v[0]'";
		$comma = ',';
	}
	if(!$usernames){
		message('no_such_item');
	}
	
	$ret = $DB_master->fetch_one("SELECT COUNT(*) AS num FROM $core->member_table AS m WHERE username IN ($usernames)");
	if($ret['num'] == 0){
		message('no_such_item');
	}
	
	$per_time = 1;
	$times = ceil($ret['num'] / $per_time);
	$hash = unique_id(16);
	
	$task = array(
		'id' => $id,
		'title' => $data['title'],
		'content' => $data['content'],
		'where' => "username IN ($usernames)",
		'offset' => 0,
		'times' => $times,
		'total' => $ret['num'],
		'message' => empty($data['send_pm']) ? false : true,
		'email' => empty($data['send_mail']) ? false : true,
		'sms' => empty($data['send_sms']) ? false : true,
		'sms_back' => empty($data['sms_back']) ? false : true,
		'per_time' => $per_time,
	);
	
	$message = p8lang($P8LANG['notify_send_note'], $ret['num']);
	
	$CACHE->write('core/modules/'. $MODULE, 'task', $hash, $task, 'serialize');
	
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
	$CACHE->delete('core/modules/'. $MODULE, 'task', $hash);

	header("location:$this_module->U_controller-list");
	exit;
}



define('NO_ADMIN_LOG', true);

$task = $CACHE->read('core/modules/'. $MODULE, 'task', $hash, 'serialize');
$task or message('access_denied');

if($task['offset'] == 0){
	$DB_master->update($this_module->table, array('sent' => 1), "id = '$id'");
}

$offset = $task['offset'] * $task['per_time'];
$query = $DB_master->query("SELECT m.id, m.username, m.name, m.email, m.cell_phone FROM $core->member_table AS m
	WHERE $task[where] LIMIT $offset,$task[per_time]");

$task['message'] && $message = &$core->load_module('message');
$task['email'] && $mailer = &$core->load_module('mail');

if($task['sms']){
	$sms = &$core->load_module('sms');
	$sms_content = str_replace(array("\t"), '', strip_tags($task['content']));
	if($task['sms_back']){
		$sms_content = $task['title'] .' '.$sms_content;
		foreach($this_module->CONFIG['status'] as $id => $v){
			//短信选择
			$sms_content .= p8lang($P8LANG['notify_sms_reply_note'], $id, $v);
		}
	}
}

$i = 0;
while($arr = $DB_master->fetch_array($query)){
	
	$_hash = unique_id(16);
	$DB_master->insert(
		$this_module->sign_in_table,
		array(
			'nid' => $task['id'],
			'uid' => $arr['id'],
			'hash' => $_hash,
		),
		array(
			'replace' => true
		)
	);
	
	if(!$task['resend']){
		$DB_master->update(
			$this_module->table,
			array(
				'send_count' => 'send_count +1'
			),
			"id = '$task[id]'",
			false
		);
	}
	
	$url = $this_module->controller .'-sign_in?id='. $task['id'] .'&uid='. $arr['id'] .'&hash='. $_hash;
	$content = p8lang($P8LANG['notify_content'], $task['content'], $url);
	
	if($task['message']){
		$m = array(
			'username' => $arr['username'],
			'system' => true,
			'title' => $task['title'],
			'content' => $content
		);
		
		$message->send($m);
	}
	
	if($task['email'] && $arr['email']){
		$mailer->set(array(
			'subject' => $task['title'],
			'message' => $content,
			'send_to' => $arr['email']
		));
		$mailer->send();
	}
	
	//目前接口貌似只有ccell支持回执
	if($task['sms']){
		$sms->send(
			$arr['cell_phone'],
			$sms_content . ($task['sms_back']? $sms->callback_header('core/notify-sms_sign_in-'. $task['id']) : '')
		);
	}
	
	$i++;
}


if($i == 0){
	//完成啦
	$CACHE->delete('core/modules/'. $MODULE, 'task', $hash);
	
	message('done', $this_router .'-list');
}

//准备下一轮
$task['offset']++;
$CACHE->write('core/modules/'. $MODULE, 'task', $hash, $task, 'serialize');
$send_note = $message = p8lang($P8LANG['sending_note'], $task['offset']);

_poster($hash,$send_note);
	
}