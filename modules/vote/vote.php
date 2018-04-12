<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $CACHE->read($SYSTEM .'/modules/'. $MODULE, 'vote', $id, 'serialize');
	//�޴�ͶƱ
	$data or message('no_such_item');
	
	$view_result = $this_controller->check_action('view_result');
	//δ����,����Ա�����տ�
	if(empty($data['enabled']) && !$view_result) message('no_such_item');
	
	$data['frame_url'] = str_replace('.thumb.jpg', '', $data['frame']);
	
	$expire = $data['expire'] && P8_TIME > $data['expire'] ? true : false;
	
	$viewable = true;
	if(empty($data['viewable']) && !($view_result)){
		//ֱ�Ӳ�����
		$viewable = false;
	}else if(!empty($data['vote_to_view']) && !($view_result || SE_ROBOT)){
		//�����ҪͶƱ���ܲ鿴���,����Ա,��ʼ��,������������
		
		if($expire){
			//���ڵ�ͶƱ����ֱ�ӿ���
			$viewable = true;
		}else{
			$cond = $UID ? " AND uid = '$UID'" : " AND uid = '". P8_IP ."'";
			$check = $DB_slave->fetch_one("SELECT timestamp FROM $this_module->voter_table WHERE vid = '$id' $cond");
			
			if(empty($check['timestamp'])){
				$viewable = false;
			}
		}
	}
	
	$rank = $data['options'];
	function _sort($a, $b){
		return $a['votes'] > $b['votes'] ? -1 : 1;
	}
	usort($rank, '_sort');
	
	$pages = '';
	//��ҳ����
	if($data['page_size']){
		$page_url = $this_url .'?id='. $id .'&page=?page?';
		$count = count($data['options']);
		$max_page = ceil($count / $data['page_size']);
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page = max($page, 1);
		$page = min($max_page, $page);
		
		$options = array_slice($data['options'], $data['page_size'] * ($page -1), $data['page_size']);
		
		$pages = list_page(array(
			'count' => $count,
			'page' => $page,
			'page_size' => $data['page_size'],
			'url' => $page_url,
		));
	}else{
		$options = &$data['options'];
	}
	
	$view_voter = $data['view_voter'] ? true : ($IS_ADMIN || $IS_FOUNDER ? true : false);
	
	//��ǩ��׺
	$LABEL_POSTFIX = array('vote_'. $id);
	
	include template($this_module, 'style/'. ($data['template'] ? $data['template'] : 'vote'));
	
}else if(REQUEST_METHOD == 'POST'){
	
	
	//ֻ����postͶƱ
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$data = $CACHE->read($SYSTEM .'/modules/'. $MODULE, 'vote', $id, 'serialize');
	//�޴�ͶƱ
	$data or message('no_such_item');
	
	if($data['captcha'] && !captcha($_POST['captcha']))message('captcha_incorrect', HTTP_REFERER, 10);
	
	if($data['expire'] && $data['expire'] < P8_TIME) message('vote_expire');
	
	$oid = isset($_POST['oid']) ? (array)$_POST['oid'] : array();
	
	$v_oid = array();
	//ȥ�������,�����ڵ�ѡ��
	$i = 0;
	foreach($oid as $v){
		if(empty($data['options'][$v])) continue;
		if($data['multi'] && $i == $data['multi']) break;
		
		$v_oid[$v] = intval($v);
		$i++;
	}
	
	//�޴�ѡ��
	$v_oid or message('no_vote_option_selected');
	$oid = $v_oid;
	
	//�����û��鲻����ͶƱ
	if($data['roles'] && !isset($data['roles'][$ROLE])){
		message('role_not_allow_vote');
	}
	
	if($data['vote_interval']){
		//������ͶƱ���,������û�ͶƱ,����UID, ��������ip
		$cond = $UID ? " AND uid = '$UID'" : " AND uid = '". P8_IP ."'";
		$interval = $data['vote_interval'] * 86400;
		
		$query = $DB_slave->query("SELECT oid, timestamp FROM $this_module->voter_table WHERE vid = '$id' $cond");
		$count = 0;
		while($arr = $DB_slave->fetch_array($query)){
			//��ȡ���û��Ķ��ڴ�ͶƱ�ļ�¼
			if(P8_TIME - $arr['timestamp'] < $interval){
				if(isset($oid[$arr['oid']])){
					//�������ʱ������,ɾ��ͶƱ��
					unset($oid[$arr['oid']]);
				}
				
				$count++;
				$time = $arr['timestamp'];
			}
		}
		$count += count($oid);
		
		//echo $count;
		if(empty($oid) || isset($time) && $data['multi'] && $count > $data['multi']){
			//ɸѡ��û�п�����ͶƱ��,ʱ�������ظ�ͶƱ
			message( p8lang($P8LANG['vote_in_interval'], $data['vote_interval'], date('Y-m-d H:i:s', $time)) );
		}
	}
	
	//ͶƱ�����
	$this_module->vote($id, $oid);
	
	message('vote_success',$this_router .'-vote?id='. $id);
	
}