<?php
defined('PHP168_PATH') or die();

/**
* 内容页生成静态
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
		//初始化多线程
		echo _poster($_GET['task_name'], $_GET['thread_id']);
		exit;
	}
	
	//搜集未完成的任务
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

//##初始化任务开始{ step: 1
if(empty($_POST['task'])){
	
	//时间范围
	$time_range = isset($_POST['time_range']) && is_array($_POST['time_range']) ? $_POST['time_range'] : array();
	//ID范围
	$id_range = isset($_POST['id_range']) ? preg_replace('/[^0-9\-,]/', '', $_POST['id_range']) : '';
	//分类
	$cids = isset($_POST['cids']) ? filter_int($_POST['cids']) : array();
	
	//仅生成一篇内容,用于刷新内容页标签时候用
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
		//去掉多余的,
		
		$range = $_range = array();
		foreach($id_range as $v){
			//是范围 n-m 这种情况
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
		//分类
		if(!empty($cids) && current($cids) != 0){
			$cond .= ' AND cid IN ('. implode(',', $cids) .')';
		}
		
		//有时间范围
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
	
	//没有要生成的文件
	if(!$count){
		message('no_cms_item_to_html');exit;
	}
	
	$perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 50;
	$perpage = max($perpage, 1);
	
	//分多少次生成
	$times = ceil($count / $perpage);
	
	$threads = isset($_POST['threads']) ? intval($_POST['threads']) : 1;
	//线程数不能比次数多
	$threads = min($threads, $times);
	
	//每个线程多少次
	$thread_pages = ceil($times / $threads);
	
	$task_name = 'view_'. unique_id(16);
	
	$mobile = isset($_POST['mobile']) ? intval($_POST['mobile']) : 0;
	
	//任务
	$data = array(
		'threads' => $threads,			//线程数
		'times' => $times,				//要生成的次数
		'start_time' => get_timer(),	//开始时间,有毫秒
		'time' => P8_TIME,				//开始时间
		'perpage' => $perpage,			//每次生成的文件数
		'where' => $cond,				//查询条件
	    'mobile' => $mobile,				//移动
		'thread' => array()				//己完成的线程
	);
	
	
	$iframe = '';
	for($i = 0; $i < $threads; $i++){
		//生成各线程信息
		$thread = array(
			//线程开始页数
			'page' => $i * $thread_pages +1,
			//线程结束页数
			'pages' => $i * $thread_pages + $thread_pages
		);
		$CACHE->write($SYSTEM, 'html_task', $task_name .'_'. ($i +1), $thread, 'serialize');
		
		$data['thread'][$i +1] = false;	//线程完成情况,true为完成
		
		$iframe .= p8lang($P8LANG['htmlize']['thread'], array($i)) .
			'<iframe src="'. $this_url .'?task_name='. $task_name .'&thread_id='.($i +1).'" width="100%" height="30" marginheight="0" marginwidth="0" frameborder="0"></iframe>';
	}
	$CACHE->write($SYSTEM, 'html_task', $task_name, $data, 'serialize');
	
	echo $iframe;
	exit;
}
//##初始化任务结束}



































//不产生日志
define('NO_ADMIN_LOG', true);


//##线程开始{ step: 2
$__task_name__ = $_POST['task'];
//任务数据
$__task__ = $CACHE->read($SYSTEM, 'html_task', $__task_name__, 'serialize');

//无线程id不能生成
isset($_POST['thread_id']) or exit('thread id required');

//读取当前线程
$__thread__ = $CACHE->read($SYSTEM, 'html_task', $__task_name__ .'_'. $_POST['thread_id'], 'serialize');

$__perpage__ = $__task__['perpage'];

//取页码和偏移量
$__page__ = $__thread__['page'];
$offset = ($__page__ -1) * $__perpage__;
if($__task__['mobile']){
    define('VIEW_HTML_MOBILE', true);
	$core->ismobile = true;
}else{
	$core->ismobile = false;
}

//############## 核心代码 ###############
//取数据,从这里开始变量要尽可能怪异,防止与页面的变量冲突
$sql = "SELECT * FROM $this_module->main_table $__task__[where] LIMIT $offset, $__perpage__";
//echo $sql;
$query = $DB_master->query($sql);

if(!$this_module->html($query)){
	message(p8lang($P8LANG['cms_item_html_unwritable'], array($this_module->_html['file'])));
}


//############## 核心代码 ###############}




















if($__page__ >= $__thread__['pages']){
	//己完成一个线程任务
	
	$__task__['thread'][$_POST['thread_id']] = true;
	$CACHE->write($SYSTEM, 'html_task', $__task_name__, $__task__, 'serialize');
	$CACHE->delete($SYSTEM, 'html_task', $__task_name__ .'_'. $_POST['thread_id']);
	
	if(count($__task__['thread']) == count(array_filter($__task__['thread']))){
		//已经完成所有线程任务
		
		$CACHE->delete($SYSTEM, 'html_task', $__task_name__, 'serialize');
	}
	
	echo p8lang($P8LANG['htmlize']['done'], array(P8_TIME - $__task__['time']));
	
}else{
	
	$__thread__['page'] = $__page__ +1;
	$CACHE->write($SYSTEM, 'html_task', $__task_name__ .'_'. $_POST['thread_id'], $__thread__, 'serialize');
	
	//更新线程信息
	_poster(
		$__task_name__,
		$_POST['thread_id'],
		p8lang($P8LANG['htmlize']['view_process'], $__thread__['page'], $__thread__['pages'])
	);
}
//##线程结束}


}