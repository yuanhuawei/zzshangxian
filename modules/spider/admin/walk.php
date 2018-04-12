<?php
defined('PHP168_PATH') or die();

/**
* �ɼ�����
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){

@set_time_limit(0);
@ignore_user_abort(false);

//������
function _poster($id, $msg = ''){
	global $this_url, $CACHE, $MODULE, $task, $P8LANG;
	
	$CACHE->write('core/modules/'. $MODULE, 'task', $id, $task, 'serialize');
	
	$form = $msg .'
<form action="'. $this_url .'" id="form" method="post">
	<input type="hidden" name="start" value="1" />
	<input type="hidden" name="id" value="'. $id .'" />'.
	$P8LANG['spider']['refresh'] .
'</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById("form").submit(); }, 1);
</script>';
	
	message($form);
	
	exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

//��ʼ������ step:1
if(empty($_POST['start'])){
	//����ID
	$id or message('access_denied');
	
	$rule = $this_module->get_rule($id, false, true);
	if(empty($rule)) message('access_denied');
	
	if($CACHE->read('core/modules/'. $MODULE, 'task', $id, 'serialize')){
		message(p8lang($P8LANG['spider']['task_running'], array($id)));
	}
	
	$item_per_time = isset($_POST['per_time']) ? intval($_POST['per_time']) : 5;
	
	$task = array(
		'rule_id' => $id,
		'offset' => 0,
		'start_time' => P8_TIME,
		'per_time' => $item_per_time,
		'list_offset' => $rule['data']['start'],
		'process' => array()
	);
	
	/*
	'process' => array(
		'pages' => 10,	//�б�ҳ����
		'items' => 20,	//�б�������
		'item_pages' => ,	//�б�������
		'item_pages' => 10	
	)
	*/
	
	/*$config = $core->get_config('core', $MODULE);
	isset($config['running_tasks']) || $config['running_tasks'] = array();
	$config['running_tasks'][$hash] = P8_TIME;
	$this_module->set_config(array('running_tasks' => $config['running_tasks']));
	*/
	_poster($id);
}


//��������־
define('NO_ADMIN_LOG', true);

$task = $CACHE->read('core/modules/'. $MODULE, 'task', $id, 'serialize');

//�����exit
if(!empty($task['done'])){
	
	$CACHE->delete('core/modules/'. $MODULE, 'task', $id);
	
	message(p8lang($P8LANG['spider']['done'], P8_TIME - $task['start_time']), $this_router .'-rule');
}








$rule = $this_module->get_rule($task['rule_id'], false, true);
if(empty($rule)) message('access_denied');


//��ʼ��ȡ�б�ҳ step:2
if(empty($task['process']['list_done'])){
	
	isset($task['process']['items']) || $task['process']['items'] = array();
	
	
	if($task['list_offset'] <= $rule['data']['end']){
		if($ret = $this_module->capture_list($rule, $task['list_offset']++)){
			$task['process']['items'] = !empty($rule['data']['reverse']) ?
				array_merge($ret['items'], $task['process']['items']) :
				array_merge($task['process']['items'], $ret['items']);
		}
		
		//goto step:2
		_poster($id, $P8LANG['spider']['item']);
	}
	
	$task['process']['list_done'] = true;
	
	//goto step: 3, �ҵ�x����¼
	_poster( $id, p8lang($P8LANG['spider']['x_items_found'], count($task['process']['items'])) );
}


//ץȡ���ݷ�ҳ step:4
if(!empty($task['process']['item_pages'])){
	
	$current = current($task['process']['items']);
	$i = 0;
	$time = P8_TIME;
	while( list($url, $v) = each($task['process']['item_pages']) ){
		
		$i++;
		if($i > $task['per_time']){
			//��ֹ��ʱ,����ת
			break;
		}
		
		if(!($item = $this_module->capture_item($rule, $url, 1))){
			//����ʧ��
			unset($task['process']['item_pages'][$url]);
			break;
		}
		
		if(
			!empty($item['pages']) && is_string($item['pages']) &&
			empty($task['process']['item_pages'][$item['pages']])
		){
			//�͵���һҳ
			$task['process']['item_pages'][$item['pages']] = 'next';
		}
		
		//׷������
		$data = array(
			'iid' => $task['process']['item_id'],
			'timestamp' => $time++,
			'data' => $item
		);
		
		$this_module->add_item($data);
		
		unset($task['process']['item_pages'][$url]);
		
	}
	
	if(empty($task['process']['item_pages'])){
		//��ҳ������, ���������URL
		array_shift($task['process']['items']);
	}
	
	//goto step:3
	_poster( $id, p8lang($P8LANG['spider']['capture_item_page'], $current['title'], count($task['process']['item_pages'])) );
}


//ץ���� step:3
$i = 0;
$time = P8_TIME;

$captured_items = array();
if(
	$tmp = $DB_master->fetch_one("SELECT captured_items FROM $this_module->rule_table WHERE id = '$rule[id]'")
){
	$captured_items = @mb_unserialize($tmp['captured_items']);
	$captured_items = $captured_items ? $captured_items : array();
}

foreach($task['process']['items'] as $url => $v){
	$i++;
	if($i > $task['per_time']){
		//����ʱ,������ת, goto step:3
		break;
	}
	
	
	if(!isset($captured_items[$url])){
		
		$captured_items[$url] = 1;
		
		if(!($item = $this_module->capture_item($rule, $url))){
			//����ʧ��
			unset($task['process']['items'][$url]);
			continue;
		}
		
		$pages = isset($item['pages']) ? $item['pages'] : false; unset($item['pages']);
		
		$data = array(
			'rid' => $rule['id'],
			'title' => strip_tags($v['title']),
			'timestamp' => $time++,
			'data' => $item
		);
		
		//�������ҳûȡ����������ͼ,���б�ҳ��
		if(empty($data['data']['frame'])){
			$data['data']['frame'] = $v['frame'];
		}
		
		$item_id = $this_module->add_item($data);
		
		if($pages != $url && $pages){
			is_array($pages) || $pages = array($pages => 'next');
			
			$task['process']['item_pages'] = $pages;
			$task['process']['item_id'] = $item_id;
			
			//��ͣ��������ȥ�ɼ���ҳ,�����ҳ�ټ��� goto step:4
			break;
		}
		
	}
	
	unset($task['process']['items'][$url]);
}

//�ظ���ͳ��
$DB_master->update(
	$this_module->rule_table,
	array( 'captured_items' => $DB_master->escape_string(serialize($captured_items)) ),
	"id = '$rule[id]'"
);


if(empty($task['process']['items'])){
	//�������
	$task['done'] = true;
}

_poster( $id, p8lang($P8LANG['spider']['capture_list'], count($task['process']['items'])) );

}