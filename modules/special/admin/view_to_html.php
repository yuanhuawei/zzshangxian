<?php
defined('PHP168_PATH') or die();

/**
* 专题页生成静态
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD != 'POST') exit;
require PHP168_PATH .'inc/html.func.php';
$__view_uri__ = '/index.php/'. $SYSTEM .'/special-view-id-{$id}';


//##初始化任务开始{ step: 1
if(empty($_POST['task'])){

	@set_time_limit(0);

	//分类
	$cids = isset($_POST['cids']) ? array_unique(filter_int($_POST['cids'])) : array();
	$ids = isset($_POST['ids']) ? array_unique(filter_int($_POST['ids'])) : array();
	$items = isset($_POST['items']) ? $_POST['items'] : 0;

	$cond = ' WHERE 1 ';
	
	//分类
	if(!empty($cids) && current($cids) != 0){
		$cond .= ' AND cid IN ('. implode(',', $cids) .')';
	}else if(!empty($ids) && current($ids) != 0){
		$cond .= ' AND id IN ('. implode(',', $ids) .')';
	
	}

	//echo "SELECT COUNT(*) AS num FROM $this_module->table $cond";exit;
	$count = $DB_master->fetch_one("SELECT COUNT(*) AS num FROM $this_module->table $cond");
	$count = $count['num'];
	
	//没有要生成的文件
	if(!$count){
		message('no_item');exit;
	}
	
	$perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 50;
	$perpage = max($perpage, 1);
	

	$task_name = 'view_to_html_task_'. unique_id(16);
	
	//任务
	$data = array(
		'time' => get_timer(),				//开始时间
		'count' =>$count,
		'page' => 0,				//当前的次数
		'perpage' => $perpage,			//每次生成的文件数
		'where' => $cond			//查询条件
	);
	
	_poster($task_name, $data, $msg = '');
	exit;
}
//##初始化任务结束}

//不产生日志
define('NO_ADMIN_LOG', true);


//##线程开始{ step: 2
$__task_name__ = $_POST['task'];
//任务数据
$__task__ = $_POST['taskd'];
//无线程id不能生成
if(!$__task__['count'])exit('thread id required');

$__perpage__ = $__task__['perpage'];

//取页码和偏移量
$__page__ = $__task__['page'];
$offset = ($__page__ -1) * $__perpage__;
$offset =max($offset,0);
//############## 核心代码 ###############
//取数据,从这里开始变量要尽可能怪异,防止与页面的变量冲突
$sql = "SELECT * FROM $this_module->table $__task__[where] LIMIT $offset, $__perpage__";
//echo $sql;exit;
$query = $DB_master->query($sql);

//############## 核心代码 ###############}

while($__arr__ = $DB_master->fetch_array($query)){
		//设置有跳转的跳过
		
		$file = p8_html_url($this_module, $__arr__, 'view', false);
		$tourl = p8_url($this_module, $__arr__, 'view');
		if($file){
			$id=$__arr__['id'];
			$basename = basename($file);
			//取路径
			$path = str_replace($basename, '', $file);
			
			$page_file = preg_replace('/#([^#]+)#/', '\1', $file);
			$no_page = preg_replace('/#([^#]+)#/', '', $file);
			$__file__ = $no_page;
			
			
			eval('$_SERVER[\'_REQUEST_URI\'] = "'. $__view_uri__ .'";');
			
			ob_start();
			require PHP168_PATH .'index.php';
			$__content__ = ob_get_clean();
			
			md($path);
			write_file($__file__, $__content__);
		}
	}
	
	$__task__['page']+=$__task__['perpage'];
	if($__task__['page']>=$__task__['count']){
		message('done',$tourl);
	}
	echo $P8LANG['html'].'-'.$__task__['page'];
	_poster($__task_name__, $__task__, $msg = '');

function _poster($task, $data, $msg = ''){
	global $this_url;
	$inputs='';
	foreach($data as $name=>$value){
		$inputs .='<input type="hidden" name="taskd['.$name.']" value="'.$value.'">';
	}
	echo '<html>
<body>
'. $msg .'
<form action="'. $this_url .'" id="form" method="post">
<input type="hidden" name="task" value="'. $task .'" />
'.$inputs.'
</form>
<script type="text/javascript">
document.getElementById("form").submit();
</script>
</body>
</html>';
	exit;
}
