<?php
/**
*重发通知通讯
**/
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$nid = isset($_GET['nid'])? intval($_GET['nid']) : '';
	echo '<html>
<body>
<form action="'. $this_url .'" id="form" method="post">
<input type="hidden" name="nid" value="'. $nid .'" />
<input type="hidden" name="ac" value="re" />
</form>
<script type="text/javascript">
document.getElementById("form").submit();
</script>
</body>
</html>';
exit;
}else if(REQUEST_METHOD == 'POST'){
	$ac = isset($_POST['ac']) ? $_POST['ac'] : '';
	if($ac == 're'){
		$nid = isset($_POST['nid'])? intval($_POST['nid']) : '';
		$id = isset($_POST['id'])? $_POST['id'] : array();
		
		$data = array();
		if(count($id)>0){
			foreach($id as $k => $v){
				if(!is_numeric($v))continue;
				$uids .= $s.$v;
				$s = ',';
			}
			$query = $core->DB_master->fetch_all("SELECT id, username, role_id FROM $core->member_table where id in($uids)");
			$core->get_cache('role');
			$split = $_data = '';
			foreach($query as $key => $rs){
				$_data .=$split.$rs['username'].'('.$rs['id'].'|'.$core->roles[$rs['role_id']]['name'].')';
				$split = ',';
			}
			$data['data']=$_data;
		}else{
			$role_gid = isset($_POST['role_gid']) ? intval($_POST['role_gid']) : 0;
			$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
			$keyword = isset($_POST['keyword']) ? html_entities(from_utf8($_POST['keyword'])) : '';
			$receive = isset($_POST['receive']) ? html_entities($_POST['receive']) : '';
			$status = isset($_POST['status']) ? html_entities($_POST['status']) : '';
			$select = select();
			$select->from($this_module->sign_in_table .' AS i', 'i.uid');
			$select->inner_join($core->member_table .' AS m', 'm.id,m.username, m.role_id', 'i.uid = m.id');
			$select->in('i.nid',$nid);
			
			if($role_id){
				$select->in('m.role_id', $role_id);
			}else if($role_gid){
				$select->in('m.role_gid', $role_gid);
			}
			if($receive !=''){
				$select->in('i.receive',$receive);
			}
			if($status!=''){
				$select->in('i.status', $status);
			}
			if($keyword){
				if(preg_match('/[^a-zA-Z]/', $keyword)){
					$select->like('m.name', $keyword);
				}else{
					$select->like('m.pinyin', $keyword);
				}
			}
			$list = $core->list_item($select);
			$core->get_cache('role');
			foreach($list as $key => $rs){
				$_data .=$split.$rs['username'].'('.$rs['id'].'|'.$core->roles[$rs['role_id']]['name'].')';
				$split = ',';
			}
			$data['data']=$_data;
		}
		
		$query = $core->DB_master->fetch_one("SELECT title, content, data, send_pm, send_mail, send_sms FROM $this_module->table where id='$nid'");
		if(!$data['data'])$data['data']=$query['data'];
		$data['id'] = $nid;
		$data['send_pm'] = $query['send_pm'];
		$data['send_mail'] = $query['send_mail'];
		$data['send_sms'] = $query['send_sms'];
		$data['title'] = $query['title'];
		$data['content'] = $query['content'];
		$ac = 'send';
		include template($this_module, 'add');
	}else
	if($ac == 'send'){
		
		$data = $this_controller->valid_data($_POST);
		$data or message('no_such_item');
		$data['timestamp'] = P8_TIME;
		$data['uid'] = $UID;
		$id = isset($_POST['id'])? intval($_POST['id']) : '';
		
		//edit only
		if(empty($_POST['send_at_once'])){	
			$this_module->update($id,$data);
			message('done',$this_router.'-list');
		}else{
		//send at once
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
			'per_time' => $per_time,
			'resend' => 1
		);
		$message = p8lang($P8LANG['notify_send_note'], $ret['num']);
			
		$CACHE->write('core/modules/'. $MODULE, 'task', $hash, $task, 'serialize');

		echo <<<EOT
<html>
<body>
<form action="$this_router-send" method="post" id="form">
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
	}
}
