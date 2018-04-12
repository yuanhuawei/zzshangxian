<?php
defined('PHP168_PATH') or die();

/**
* 从采集模块取内容
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	include template($this_module, 'spider', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){



	
$hash = isset($_POST['hash']) ? preg_replace('/[^0-9a-zA-Z]/', '', $_POST['hash']) : '';

@set_time_limit(0);
@ignore_user_abort(false);

//传送门
function _poster($hash, $msg = ''){
	
	$form = '<form id="form" method="post"><input type="hidden" name="hash" value="'. $hash .'" /></form>
<script type="text/javascript">
document.getElementById("form").submit();
</script>';
	
	message($msg . $form);
	
	exit;
}

//初始化任务 step: 1
if(empty($hash)){
	
	$rid = isset($_POST['rid']) ? intval($_POST['rid']) : 0;
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$cid = isset($_POST['cid']) ? intval($_POST['cid']) : array();
	$count = isset($_POST['id']) ? intval($_POST['count']) : 0;
	$per_time = isset($_POST['per_time']) ? intval($_POST['per_time']) : 5;
	$per_time = max(1, $per_time);
	$delete = empty($_POST['delete']) ? false : true;
	
	if($count <= 0){
		message('access_denied');
	}
	
	$CAT = &$this_system->fetch_category($cid);
	//初始化模型
	
	$hash = unique_id(16);
	
	$task = array(
		'cid' => $cid,
		'model' => $CAT['model'],
		'count' => $count,
		'html' => $CAT['htmlize'],
		'per_time' => $per_time,
		'offset' => 0,
		'verify' => empty($_POST['verify']) ? 0 : ($this_controller->check_admin_action('verify') ? 1 : 0),
		'delete' => $delete,
	);
	
	if($rid){
		$task['rid'] = $rid;
	}else if($id){
		$task['id'] = $id;
	}else{
		message('access_denied');
	}
	
	$CACHE->write($SYSTEM .'/modules', $MODULE, 'spider_task_'. $hash, $task, 'serialize');
	
	_poster($hash);
}





define('NO_ADMIN_LOG', false);

$task = $CACHE->read($SYSTEM .'/modules', $MODULE, 'spider_task_'. $hash, 'serialize');
$task or message('access_denied');

if(isset($task['rid'])){
	$where = "rid = '$task[rid]'";
}else if(isset($task['id'])){
	$where = 'id IN ('. implode(',', $task['id']) .')';
}

$spider = &$core->load_module('spider');

$items = $spider->get_item(array(
	'where' => $where,
	'offset' => $task['offset'] * $task['per_time'],
	'limit' => $task['per_time']
));


if(empty($items)){
	//完成啦
	
	if($task['delete']){
		//删除,不要删除关联附件
		$spider->delete_item(array(
			'where' => $where
		));
	}
	
	$CACHE->delete($SYSTEM .'/modules', $MODULE, 'spider_task_'. $hash);
	
	message($P8LANG['cms_item_spider_done'], $this_url);
}



//初始化模型
$_REQUEST['model'] = $task['model'];
$this_system->init_model();

//获取数据
function get_data(&$POST){
	global $this_model;
	
	//来源
	$POST['source'] = isset($POST['data']['source_name']) ? 
		$POST['data']['source_name'] . (isset($POST['data']['source_url']) ? '|'. $POST['data']['source_url'] : '') : '';
	//作者
	$POST['author'] = isset($POST['data']['author']) ? $POST['data']['author'] : '';
	//封面
	$POST['frame'] = isset($POST['data']['frame']) ? $POST['data']['frame'] : '';
	//摘要
	$POST['summary'] = isset($POST['data']['summary']) ? $POST['data']['summary'] : '';
	
	//發布時間也用采集的
	$POST['timestamp'] = !empty($POST['data']['timestamp']) ? str_replace('　','',trim($POST['data']['timestamp'])) : $POST['timestamp'];
	
	$POST['addon_title'] = isset($POST['data']['addon_title']) ? $POST['data']['addon_title'] : '';
	$POST['addon_frame'] = isset($POST['data']['addon_frame']) ? $POST['data']['addon_frame'] : '';
	$POST['addon_summary'] = isset($POST['data']['addon_summary']) ? $POST['data']['addon_summary'] : '';
	
	$POST['field#'] = array();
	
	foreach($this_model['fields'] as $field => $v){
		switch($v['widget']){
		
		case 'multi_uploader': case 'uploader': case 'image_uploader':
			$POST['field#'][$field] = array();
			
			isset($POST['data'][$field .'_title']) && 
				$POST['field#'][$field]['title'] = $POST['data'][$field .'_title'];
			
			isset($POST['data'][$field .'_url']) && 
				$POST['field#'][$field]['url'] = $POST['data'][$field .'_url'];
			
			isset($POST['data'][$field .'_thumb']) && 
				$POST['field#'][$field]['thumb'] = $POST['data'][$field .'_thumb'];
		break;
		
		default:
			isset($POST['data'][$field]) &&
				$POST['field#'][$field] = $POST['data'][$field];
		}
	}
	
	unset($POST['data']);
}

$ids = $comma = '';
//入库 step: 2
foreach($items as $post){
	
	
	$post['cid'] = $task['cid'];
	$post['verify'] = $task['verify'];
	
	$iid = $post['id'];
	
	//自定义模型处理数据
	get_data($post);
	
	$id = $this_controller->add($post);
	
	if($post['pages'] > 1){
		//有分页,追加
		$_items = $spider->get_item(array('iid' => $iid));
		
		foreach($_items as $_post){
			$_post['iid'] = $id;
			
			get_data($_post);
			
			$this_controller->addon($_post);
		}
	}
	
	$ids .= $comma . $id;
	$comma = ',';
}

//生成静态
if($task['verify'] && $task['html'] && $ids){
	$this_module->html($DB_master->query("SELECT * FROM $this_module->main_table WHERE id IN($ids)"));
}

//偏移递增
$task['offset']++;
$CACHE->write($SYSTEM .'/modules', $MODULE, 'spider_task_'. $hash, $task, 'serialize');

_poster($hash, $P8LANG['cms_item_spidering']);

}