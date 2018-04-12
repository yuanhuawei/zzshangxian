<?php
defined('PHP168_PATH') or die();

/**
* ����ҳ���ɾ�̬
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');


define('THIS_URL', $this_url);

function _poster($task, $thread_id, $msg = ''){
	echo '<html>
<body>
'. $msg .'
<form action="'. THIS_URL .'" id="form" method="post">
<input type="hidden" name="task" value="'. $task .'" />
<input type="hidden" name="thread_id" value="'. $thread_id .'" />
</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById("form").submit(); }, 1);
</script>
</body>
</html>';
	exit;
}

if(REQUEST_METHOD == 'GET'){
	
	
	if(isset($_GET['thread_id'])){
		//��ʼ�����߳�
		echo _poster($_GET['task_name'], $_GET['thread_id']);
		exit;
	}
	
	//�Ѽ�δ��ɵ�����
	$_tasks = glob(CACHE_PATH . $SYSTEM .'/html_task/view_*.php');
	$_tasks || $_tasks = array();
	$tasks = array();
	foreach($_tasks as $v){
		$data = include $v;
		$tasks[] = array(
			'time' => date('Y-m-d H:i:s', $data['time']),
			'threads' => $data['threads'],
			'completed_thread' => count(array_filter($data['thread']))
		);
	}
	unset($_tasks, $data);
	
	include template($this_module, 'view_to_html', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){






















@set_time_limit(0);
@ignore_user_abort(false);

//##��ʼ������ʼ{ step: 1
if(empty($_POST['task'])){
	
	//ʱ�䷶Χ
	$time_range = isset($_POST['time_range']) && is_array($_POST['time_range']) ? $_POST['time_range'] : array();
	//ID��Χ
	$id_range = isset($_POST['id_range']) ? preg_replace('/[^0-9\-,]/', '', $_POST['id_range']) : '';
	//����
	$cids = isset($_POST['cids']) ? filter_int($_POST['cids']) : array();
	
	//������һƪ����,����ˢ������ҳ��ǩʱ����
	$items = isset($_POST['items']) ? $_POST['items'] : 0;
	if($items == 1){
		$id_range = $comma = '';
		
		$query = $DB_master->query("SELECT id FROM $this_module->main_table". ($cids ? ' WHERE cid IN('. implode(',', $cids) .') ' : '') ." GROUP BY cid");
		while($arr = $DB_master->fetch_array($query)){
			$id_range .= $comma . $arr['id'];
			$comma = ',';
		}
	}
	$cond = ' WHERE 1 ';
	
	if(!empty($id_range)){
		$id_range = array_filter(explode(',', $id_range));
		//ȥ�������,
		
		$range = $_range = array();
		foreach($id_range as $v){
			//�Ƿ�Χ n-m �������
			if(strpos($v, '-') !== false){
				$tmp = array_filter(explode('-', $v));
				$tmp_cond = array();
				if(!empty($tmp[0])){
					$tmp_cond[] = 'id > '. $tmp[0];
				}
				
				if(!empty($tmp[1])){
					$tmp_cond[] = 'id < '. $tmp[1];
				}
				
				$_range[] = '('. implode(' AND ', $tmp_cond) .')';
			}else{
				$range[] = $v;
			}
		}
		
		$range = implode(',', $range);
		$_range = implode(' OR ', $_range);
		
		if(!empty($range)){
			$cond .= ' AND id IN ('. $range .')';
		}
		
		if(!empty($_range)){
			$cond .= ' AND '. $_range;
		}
	}else{
		//����
		if(!empty($cids) && current($cids) != 0){
			$cond .= ' AND cid IN ('. implode(',', $cids) .')';
		}
		
		//��ʱ�䷶Χ
		if(!empty($time_range[0])){
			$cond .= ' AND timestamp > '. strtotime($time_range[0]);
		}
		
		if(!empty($time_range[1])){
			$cond .= ' AND timestamp < '. strtotime($time_range[1]);
		}
		
	}
	
	//echo $cond;exit;
	$count = $DB_master->fetch_one("SELECT COUNT(*) AS num FROM $this_module->main_table $cond");
	$count = $count['num'];
	
	//û��Ҫ���ɵ��ļ�
	if(!$count){
		message('no_cms_item_to_html');exit;
	}
	
	$perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 50;
	$perpage = max($perpage, 1);
	
	//�ֶ��ٴ�����
	$times = ceil($count / $perpage);
	
	$threads = isset($_POST['threads']) ? intval($_POST['threads']) : 1;
	//�߳������ܱȴ�����
	$threads = min($threads, $times);
	
	//ÿ���̶߳��ٴ�
	$thread_pages = ceil($times / $threads);
	
	$task_name = 'view_'. unique_id(16);
	
	$mobile = isset($_POST['mobile']) ? intval($_POST['mobile']) : 0;
	
	//����
	$data = array(
		'threads' => $threads,			//�߳���
		'times' => $times,				//Ҫ���ɵĴ���
		'start_time' => get_timer(),	//��ʼʱ��,�к���
		'time' => P8_TIME,				//��ʼʱ��
		'perpage' => $perpage,			//ÿ�����ɵ��ļ���
		'where' => $cond,				//��ѯ����
	    'mobile' => $mobile,				//�ƶ�
		'thread' => array()				//����ɵ��߳�
	);
	
	
	$iframe = '';
	for($i = 0; $i < $threads; $i++){
		//���ɸ��߳���Ϣ
		$thread = array(
			//�߳̿�ʼҳ��
			'page' => $i * $thread_pages +1,
			//�߳̽���ҳ��
			'pages' => $i * $thread_pages + $thread_pages
		);
		$CACHE->write($SYSTEM, 'html_task', $task_name .'_'. ($i +1), $thread, 'serialize');
		
		$data['thread'][$i +1] = false;	//�߳�������,trueΪ���
		
		$iframe .= p8lang($P8LANG['htmlize']['thread'], array($i)) .
			'<iframe src="'. $this_url .'?task_name='. $task_name .'&thread_id='.($i +1).'" width="100%" height="30" marginheight="0" marginwidth="0" frameborder="0"></iframe>';
	}
	$CACHE->write($SYSTEM, 'html_task', $task_name, $data, 'serialize');
	
	echo $iframe;
	exit;
}
//##��ʼ���������}



































//��������־
define('NO_ADMIN_LOG', true);


//##�߳̿�ʼ{ step: 2
$__task_name__ = $_POST['task'];
//��������
$__task__ = $CACHE->read($SYSTEM, 'html_task', $__task_name__, 'serialize');

//���߳�id��������
isset($_POST['thread_id']) or exit('thread id required');

//��ȡ��ǰ�߳�
$__thread__ = $CACHE->read($SYSTEM, 'html_task', $__task_name__ .'_'. $_POST['thread_id'], 'serialize');

$__perpage__ = $__task__['perpage'];

//ȡҳ���ƫ����
$__page__ = $__thread__['page'];
$offset = ($__page__ -1) * $__perpage__;
if($__task__['mobile']){
    define('VIEW_HTML_MOBILE', true);
	$core->ismobile = true;
}else{
	$core->ismobile = false;
}

//############## ���Ĵ��� ###############
//ȡ����,�����￪ʼ����Ҫ�����ܹ���,��ֹ��ҳ��ı�����ͻ
$sql = "SELECT * FROM $this_module->main_table $__task__[where] LIMIT $offset, $__perpage__";
//echo $sql;
$query = $DB_master->query($sql);

if(!$this_module->html($query)){
	message(p8lang($P8LANG['cms_item_html_unwritable'], array($this_module->_html['file'])));
}


//############## ���Ĵ��� ###############}




















if($__page__ >= $__thread__['pages']){
	//�����һ���߳�����
	
	$__task__['thread'][$_POST['thread_id']] = true;
	$CACHE->write($SYSTEM, 'html_task', $__task_name__, $__task__, 'serialize');
	$CACHE->delete($SYSTEM, 'html_task', $__task_name__ .'_'. $_POST['thread_id']);
	
	if(count($__task__['thread']) == count(array_filter($__task__['thread']))){
		//�Ѿ���������߳�����
		
		$CACHE->delete($SYSTEM, 'html_task', $__task_name__, 'serialize');
	}
	
	echo p8lang($P8LANG['htmlize']['done'], array(P8_TIME - $__task__['time']));
	
}else{
	
	$__thread__['page'] = $__page__ +1;
	$CACHE->write($SYSTEM, 'html_task', $__task_name__ .'_'. $_POST['thread_id'], $__thread__, 'serialize');
	
	//�����߳���Ϣ
	_poster(
		$__task_name__,
		$_POST['thread_id'],
		p8lang($P8LANG['htmlize']['view_process'], $__thread__['page'], $__thread__['pages'])
	);
}
//##�߳̽���}


}