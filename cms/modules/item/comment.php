<?php
defined('PHP168_PATH') or die();

/**
* 评论
**/
load_language($this_module, 'comment');
//模块关闭了评论
if(empty($this_module->CONFIG['comment']['enabled'])){
	message($P8LANG['cms_item']['comment_denied']);
}

if(REQUEST_METHOD == 'GET'){
if($URL_PARAMS){
	foreach($URL_PARAMS as $k => $v){
		switch($v){
		
		case 'iid':
			//ID
			$iid = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
		break;
		
		case 'page':
			//页码
			$page = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 1;
			$page = max(1, $page);
		break;
		
		}
	}
}else{
//查看评论,用JSONP方式,可以跨域
	$iid = isset($_GET['iid']) ? intval($_GET['iid']) : 0;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
}
$iid or message($P8LANG['cms_item']['comment_denied']);
$allow_comment = $this_controller->check_action('comment');

//查询内容
$select = select();
$select->from($this_module->main_table, 'id, model, cid, url, title, timestamp, views, comments, allow_comment');
$select->in('id', $iid);
$data = $core->select($select, array('single' => true));
if(empty($data) || empty($data['allow_comment'])) message($P8LANG['cms_item']['comment_denied']);

$this_module->set_model($data['model']);


$page = max($page, 1);

$page = max(1, $page);

$count = $data['comments'];
$page_size = $this_module->CONFIG['comment']['page_size'];

$pages = '';

$page_url = 'javascript:comment.request(?page?)';
$allow_comment = $this_controller->check_action($ACTION);

if(!P8_AJAX_REQUEST){
	//非AJAX请求,查看评论的第一页
	
	$CAT = $this_system->fetch_category($data['cid']);
	$data['#category'] = &$CAT;
	$item_title = $data['title'];
	$item_url = p8_url($this_module, $data, 'view');
	
	include template($this_module, 'comment');
	
}else{
	
	//header('Content-type: text/javascript; charset=utf-8');
	
	$view_page = false;
	if(!empty($_GET['view_page'])){
		$view_page = true;
		$page = 0;
		$page_size = $this_module->CONFIG['comment']['view_page_size'];
		
	}else{
		$pages = list_page(array(
			'count' => $count,
			'page' => $page,
			'page_size' => $page_size,
			'url' => $page_url
		));
	}
	
	//评论列表
	$select = select();
	$select->from($this_module->TABLE_ .'comment', 'id, username, quote, content, timestamp, digg, oppose');
	$select->in('iid', $iid);
	$select->order('timestamp DESC');
	
	$_list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size
		)
	);
	
	$list = $quotes = array();
	/* 读取引用 */
	$ids = $comma = '';
	foreach($_list as $v){
		$list[$v['id']] = $v;
		
		if($v['quote']){
			$ids .= $comma . $v['quote'];
			$comma = ',';
		}
	}
	unset($_list);
	
	if($ids){
		$select = select();
		$select->from($this_module->TABLE_ .'comment', 'id, username, content, timestamp');
		$select->in('id', explode(',', $ids));
		
		$_contents = $core->list_item(
			$select,
			array(
				'count' => 0,
				'page' => 0,
				'page_size' => 0
			)
		);
		
		foreach($_contents as $v){
			$quotes[$v['id']] = $v;
		}
		unset($_contents);
	}
	
	//以JSONP的方式请求
	$callback = isset($_GET['callback']) ? $_GET['callback'] : '';
	
	$json = array(
		'items' => &$list,	//评论
		'count' => $count,
		'quotes' => &$quotes,
		'allow_comment' => $allow_comment,
		'pages' => &$pages	//分页
	);
	
	exit($callback .'('. p8_json($json) .')');
}























}else if(REQUEST_METHOD == 'POST'){

check_spam() && exit('<script type="text/javascript">alert("'. $P8LANG['dont_spam'] .'");</script>');

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch($action){

case 'add':
	//发表评论
	
	//检查权限
	$this_controller->check_action('comment') or message('no_privilege');
	
	$data = array();
	
	$data['iid'] = isset($_POST['iid']) ? intval($_POST['iid']) : 0;
	$check = $this_module->data('read', $data['iid']);
	//$DB_slave->fetch_one("SELECT id, allow_comment, model FROM $this_module->main_table WHERE id = '$data[iid]'");
	if(empty($check) || empty($check['allow_comment'])) message($P8LANG['cms_item']['comment_denied']);
	
	$data['content'] = isset($_POST['content']) ? filter_word(html_entities(trim($_POST['content']))) : '';
	if(strlen($data['content']) < 5){
		
		exit;
	}
	
	$models = $this_system->get_models();
	$mid = $models[$check['model']]['id'];
	
	//引用评论
	$data['quote'] = '';
	$reply_id = isset($_POST['reply_id']) ? intval($_POST['reply_id']) : 0;
	if(
		$reply_id &&
		$tmp = $DB_slave->fetch_one("SELECT id, quote FROM {$this_module->TABLE_}comment WHERE id = '$reply_id'")
	){
		$data['quote'] = $tmp['quote'] ? $tmp['quote'] .','. $tmp['id'] : $tmp['id'];
	}
	
	
	if(empty($UID)){
		//获取非登录者的ip地址
		require PHP168_PATH .'inc/ip.class.php';
		$ip = new IpLocation();
		$ipf = $ip->get(P8_IP);
		$USERNAME = $ipf['country'] . $P8LANG['cms_item']['comment_e-friend'];
	}
	
	$data['mid'] = $mid;
	$data['ip'] = P8_IP;
	$data['uid'] = $UID;
	$data['username'] = $USERNAME;
	$data['timestamp'] = P8_TIME;
	$verified = empty($this_module->CONFIG['comment']['require_verify']) ? 1 : 0;
	
	
	//插入数据
	if(
		$id = $DB_master->insert(
			$this_module->TABLE_ .'comment_id',
			array('id' => ''),
			array('return_id' => true)
		)
	){
		$data['id'] = $id;
		
		if($verified){
			$DB_master->insert(
				$this_module->TABLE_ .'comment',
				$data
			);
			
			$DB_master->update(
				$this_module->main_table,
				array('comments' => 'comments +1'),
				"id = '$data[iid]'",
				false
			);
			
			$this_module->set_model($check['model']);
			
			$DB_master->update(
				$this_module->table,
				array('comments' => 'comments +1'),
				"id = '$data[iid]'",
				false
			);
		}else{
			
			$DB_master->insert(
				$this_module->TABLE_ .'comment_unverified',
				$data
			);
		}
	}
	
	$data['digg'] = 0;
	$front = isset($_POST['front']) ? 1 : 0;
	if(!empty($core->CONFIG['base_domain']))
			echo '<script type="text/javascript">document.domain = \''.$core->CONFIG['base_domain'].'\'; </script>';
	if($front)
		exit('<script type="text/javascript">alert("'. $P8LANG['cms_item']['comment_success'] .'"); window.parent.change_count(); </script>');
	else
		exit('<script type="text/javascript">alert("'. $P8LANG['cms_item']['comment_success'] .'");window.parent.change_count();window.parent.insert_comment('. p8_json($data) .');window.parent.location.hash = \'top\';</script>');
break;
























case 'digg':
	
	//顶评论,只提供AJAX
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or exit('1');
	
	$DB_master->update(
		$this_module->TABLE_ .'comment',
		array(
			'digg' => 'digg +1'
		),
		"id = '$id'",
		false
	);
	
	exit('1');
	
break;

case 'delete':
	//删除评论,只提供AJAX
	$this_controller->check_admin_action('delete_comment') or exit('[]');
	
	$iid = isset($_POST['iid']) ? filter_int($_POST['iid']) : array();
	$iid or exit('[]');
	
	$DB_master->delete(
		$this_module->TABLE_ .'comment',
		'iid IN ('. implode(',', $iid) .')'
	) or exit('[]');
	
	exit(jsonencode($iid));
	
break;

default:
	message('access_denied');

}



}