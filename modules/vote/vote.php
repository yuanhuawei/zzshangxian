<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $CACHE->read($SYSTEM .'/modules/'. $MODULE, 'vote', $id, 'serialize');
	//无此投票
	$data or message('no_such_item');
	
	$view_result = $this_controller->check_action('view_result');
	//未开启,管理员可以照看
	if(empty($data['enabled']) && !$view_result) message('no_such_item');
	
	$data['frame_url'] = str_replace('.thumb.jpg', '', $data['frame']);
	
	$expire = $data['expire'] && P8_TIME > $data['expire'] ? true : false;
	
	$viewable = true;
	if(empty($data['viewable']) && !($view_result)){
		//直接不允许看
		$viewable = false;
	}else if(!empty($data['vote_to_view']) && !($view_result || SE_ROBOT)){
		//如果需要投票才能查看结果,管理员,创始人,搜索引擎例外
		
		if($expire){
			//过期的投票可以直接看了
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
	//分页功能
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
	
	//标签后缀
	$LABEL_POSTFIX = array('vote_'. $id);
	
	include template($this_module, 'style/'. ($data['template'] ? $data['template'] : 'vote'));
	
}else if(REQUEST_METHOD == 'POST'){
	
	
	//只允许post投票
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$data = $CACHE->read($SYSTEM .'/modules/'. $MODULE, 'vote', $id, 'serialize');
	//无此投票
	$data or message('no_such_item');
	
	if($data['captcha'] && !captcha($_POST['captcha']))message('captcha_incorrect', HTTP_REFERER, 10);
	
	if($data['expire'] && $data['expire'] < P8_TIME) message('vote_expire');
	
	$oid = isset($_POST['oid']) ? (array)$_POST['oid'] : array();
	
	$v_oid = array();
	//去掉多余的,不存在的选项
	$i = 0;
	foreach($oid as $v){
		if(empty($data['options'][$v])) continue;
		if($data['multi'] && $i == $data['multi']) break;
		
		$v_oid[$v] = intval($v);
		$i++;
	}
	
	//无此选项
	$v_oid or message('no_vote_option_selected');
	$oid = $v_oid;
	
	//所在用户组不允许投票
	if($data['roles'] && !isset($data['roles'][$ROLE])){
		message('role_not_allow_vote');
	}
	
	if($data['vote_interval']){
		//限制了投票间隔,如果是用户投票,限制UID, 否则限制ip
		$cond = $UID ? " AND uid = '$UID'" : " AND uid = '". P8_IP ."'";
		$interval = $data['vote_interval'] * 86400;
		
		$query = $DB_slave->query("SELECT oid, timestamp FROM $this_module->voter_table WHERE vid = '$id' $cond");
		$count = 0;
		while($arr = $DB_slave->fetch_array($query)){
			//读取该用户的对于此投票的记录
			if(P8_TIME - $arr['timestamp'] < $interval){
				if(isset($oid[$arr['oid']])){
					//如果还在时间间隔内,删除投票项
					unset($oid[$arr['oid']]);
				}
				
				$count++;
				$time = $arr['timestamp'];
			}
		}
		$count += count($oid);
		
		//echo $count;
		if(empty($oid) || isset($time) && $data['multi'] && $count > $data['multi']){
			//筛选到没有可入库的投票项,时间间隔内重复投票
			message( p8lang($P8LANG['vote_in_interval'], $data['vote_interval'], date('Y-m-d H:i:s', $time)) );
		}
	}
	
	//投票项入库
	$this_module->vote($id, $oid);
	
	message('vote_success',$this_router .'-vote?id='. $id);
	
}