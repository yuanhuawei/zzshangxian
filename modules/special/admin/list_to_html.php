<?php
defined('PHP168_PATH') or die();

/**
* 专题页生成静态
**/

$this_controller->check_admin_action('edit') or message('no_privilege');
if(REQUEST_METHOD != 'POST') exit;
require PHP168_PATH .'inc/html.func.php';
$__list_uri__ = '/index.php/'. $SYSTEM .'/special-list-category-{$id}-page-{$page}';
$category = &$this_module->category;
$category->get_cache();
//## 初始化任务 ##{ step: 1

if(empty($_POST['task'])){
	@set_time_limit(0);
	$task_name = 'list_to_html_task_'. unique_id(16);
	
	$cids = isset($_POST['cids']) ? array_unique(filter_int($_POST['cids'])) : array();
	$perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 50;
	if(empty($cids) || current($cids) == 0){
		//所有分类
		$category_count = count($category->categories);
		
		$categories = array();
		foreach($category->categories as $v){
			$categories[] = $v['id'];
		}
		
	}else{
		$category_count = count($cids);
		
		$categories = $cids;
	}
	
	$threads = isset($_GET['threads']) ? intval($_GET['threads']) : 1;
	$threads = max($threads, 1);
	
	$pages = isset($_POST['pages']) ? intval($_POST['pages']) : 0;
	$pages = max($pages, 0);
	
	$data = array(
		'category_offset' => 0,			//分类偏移
		'category_count' => $category_count,
		'categories' => $categories,
		'threads' => $threads,			//线程数
		//'times' => $times,			//总共要生成次数
		'start_time' => get_timer(),	//开始时间,有毫秒
		'time' => P8_TIME,				//开始时间
		'perpage' => $perpage,			//每页生成的文件数
		'pages' => $pages,				//仅生成几页
		'type' => empty($_POST['type']) ? 0 : intval($_POST['type']),
		'thread' => array()				//己完成的线程
	);
	$CACHE->write($SYSTEM, 'html_task', $task_name, $data, 'serialize');
	
	echo '开始生成';
	echo poster($task_name, 1);
	exit;
}

//## 初始化任务结束 ##}



















if(REQUEST_METHOD != 'POST') exit;

//不产生日志
define('NO_ADMIN_LOG', true);

function _done(){
	global $__task__, $__task_name__, $P8LANG, $SYSTEM, $CACHE;
	echo $P8LANG['done']. (get_timer() - $__task__['start_time']);
	$CACHE->delete($SYSTEM, 'html_task', $__task_name__);
	exit;
}

//从这里开始,变量尽可能怪异,防止与页面上的变量冲突,用__包围__

$__task_name__ = $_POST['task'];
//任务数据

$__task__ = $CACHE->read($SYSTEM, 'html_task', $__task_name__, 'serialize');

$__task__ or message('access_denied');

$__category_count__ = $__task__['category_count'];
$__category_offset__ = $__task__['category_offset'];

if(!isset($__task__['categories'][$__category_offset__])){
	exit('no_cat');
}

$id = $__task__['categories'][$__category_offset__];

//获取分类信息
$__CAT__ = $category->categories[$id];
$__CAT__['is_category'] = true;


//每页生成的文件数
$__perpage__ = $__task__['perpage'];

//如果当前分类页码为空,初始化当前分类任务 step: 2
if(empty($__task__['current_category_page'])){
	//分类的页数
	//如果是大分类,只生成封面页就可以了,或者仅生成第一页
	if($__CAT__['type'] == 1){
		$pages = 1;
	}else{
		$_pages = ceil($__CAT__['item_count'] / $__CAT__['page_size']);
		$pages = $__task__['pages'] && $__task__['pages'] <= $_pages ? $__task__['pages'] : $_pages;
	}
	$pages = max($pages, 1);
	
	//第1页开始
	$__task__['current_category_page'] = 1;

	if(
		empty($this_module->CONFIG['htmlize']) ||
		($__task__['type'] && $__CAT__['type'] != $__task__['type'])
	)
	{
		//如果分类是不生成静态的,或类型不匹配,或当前模型有可过滤的字段,跳到下一个分类去
		$__task__['category_offset']++;
		
		//没有分类了,完成
		if($__task__['category_offset'] >= $__task__['category_count'] -1) _done();
		
		unset($__task__['current_category_page']);
		
		echo p8lang($P8LANG['cms_item']['htmlize']['list_skip'], $__task__['category_offset'], $__task__['category_count']);
	}
	
	//分类的页数
	$__task__['current_category_pages'] = $pages;
	$CACHE->write($SYSTEM, 'html_task', $__task_name__, $__task__, 'serialize');
	
	
	echo poster($__task_name__);
	exit;
}

$__current_category_page__ = $__task__['current_category_page'];


//生成一个分类 step: 3
for($__i__ = 0; $__i__ < $__perpage__; $__i__++){
	
	//############## 核心代码 ###############{
	
	$__page__ = $page = $__current_category_page__ + $__i__;
	
	$file = p8_html_url($this_module, $__CAT__, 'list', false);
	

	if($file){
		
		$basename = basename($file);
		//取路径
		$path = str_replace($basename, '', $file);
		
		$page_file = preg_replace('/#([^#]+)#/', '\1', $file);
		$no_page = preg_replace('/#([^#]+)#/', '', $file);
		
		if($page == 1){
			//如果是这种情况{$system_url}/#list-{$page}.html#
			if(preg_match('/^#.*\.(.*)#$/', $basename, $m)){
				$__file__ = $path .'index.'. $m[1];
			}else{
				$__file__ = $no_page;
			}
			//$__file__ = preg_match('/^#.*#$/', $basename) ? $path .'index.html' : $no_page;
		}else{
			$__file__ = str_replace('?page?', $page, $page_file);
		}
		
		eval('$_SERVER[\'_REQUEST_URI\'] = "'. $__list_uri__ .'";');
		
		ob_start();
		require PHP168_PATH .'index.php';
		$__content__ = ob_get_clean();
		
		md($path);
		write_file($__file__, $__content__);
	}
	//############## 核心代码 ###############}
	
	if($__page__ >= $__task__['current_category_pages']){
		//到达分类页数,即一个分类生成完毕
		$__task__['category_offset']++;
		if($__task__['category_offset'] >= $__task__['category_count']){
			//所有分类生成结束
			_done();
		}
		
		unset($__task__['current_category_page']);
		$__task__['category_offset'] = $__task__['category_offset'];
		$CACHE->write($SYSTEM,'html_task', $__task_name__, $__task__, 'serialize');
		
		
		echo p8lang(
			$P8LANG['cms_item']['htmlize']['list_process'],
			$__task__['category_offset'], $__task__['category_count'], $__page__, $__task__['current_category_pages']
		);
		echo poster($__task_name__);
		exit;
	}
	
}

echo p8lang(
	$P8LANG['cms_item']['htmlize']['list_process'],
	$__task__['category_offset'], $__task__['category_count'], $__page__, $__task__['current_category_pages']
);

//一次不能生成一个分类的页数,继续生成
$__task__['current_category_page'] = ++$__page__;
$CACHE->write($SYSTEM, 'html_task', $__task_name__, $__task__, 'serialize');

echo poster($__task_name__);

?>