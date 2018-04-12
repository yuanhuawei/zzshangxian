<?php
defined('PHP168_PATH') or die();

/**
* ר��ҳ���ɾ�̬
**/

$this_controller->check_admin_action('edit') or message('no_privilege');
if(REQUEST_METHOD != 'POST') exit;
require PHP168_PATH .'inc/html.func.php';
$__list_uri__ = '/index.php/'. $SYSTEM .'/special-list-category-{$id}-page-{$page}';
$category = &$this_module->category;
$category->get_cache();
//## ��ʼ������ ##{ step: 1

if(empty($_POST['task'])){
	@set_time_limit(0);
	$task_name = 'list_to_html_task_'. unique_id(16);
	
	$cids = isset($_POST['cids']) ? array_unique(filter_int($_POST['cids'])) : array();
	$perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 50;
	if(empty($cids) || current($cids) == 0){
		//���з���
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
		'category_offset' => 0,			//����ƫ��
		'category_count' => $category_count,
		'categories' => $categories,
		'threads' => $threads,			//�߳���
		//'times' => $times,			//�ܹ�Ҫ���ɴ���
		'start_time' => get_timer(),	//��ʼʱ��,�к���
		'time' => P8_TIME,				//��ʼʱ��
		'perpage' => $perpage,			//ÿҳ���ɵ��ļ���
		'pages' => $pages,				//�����ɼ�ҳ
		'type' => empty($_POST['type']) ? 0 : intval($_POST['type']),
		'thread' => array()				//����ɵ��߳�
	);
	$CACHE->write($SYSTEM, 'html_task', $task_name, $data, 'serialize');
	
	echo '��ʼ����';
	echo poster($task_name, 1);
	exit;
}

//## ��ʼ��������� ##}



















if(REQUEST_METHOD != 'POST') exit;

//��������־
define('NO_ADMIN_LOG', true);

function _done(){
	global $__task__, $__task_name__, $P8LANG, $SYSTEM, $CACHE;
	echo $P8LANG['done']. (get_timer() - $__task__['start_time']);
	$CACHE->delete($SYSTEM, 'html_task', $__task_name__);
	exit;
}

//�����￪ʼ,���������ܹ���,��ֹ��ҳ���ϵı�����ͻ,��__��Χ__

$__task_name__ = $_POST['task'];
//��������

$__task__ = $CACHE->read($SYSTEM, 'html_task', $__task_name__, 'serialize');

$__task__ or message('access_denied');

$__category_count__ = $__task__['category_count'];
$__category_offset__ = $__task__['category_offset'];

if(!isset($__task__['categories'][$__category_offset__])){
	exit('no_cat');
}

$id = $__task__['categories'][$__category_offset__];

//��ȡ������Ϣ
$__CAT__ = $category->categories[$id];
$__CAT__['is_category'] = true;


//ÿҳ���ɵ��ļ���
$__perpage__ = $__task__['perpage'];

//�����ǰ����ҳ��Ϊ��,��ʼ����ǰ�������� step: 2
if(empty($__task__['current_category_page'])){
	//�����ҳ��
	//����Ǵ����,ֻ���ɷ���ҳ�Ϳ�����,���߽����ɵ�һҳ
	if($__CAT__['type'] == 1){
		$pages = 1;
	}else{
		$_pages = ceil($__CAT__['item_count'] / $__CAT__['page_size']);
		$pages = $__task__['pages'] && $__task__['pages'] <= $_pages ? $__task__['pages'] : $_pages;
	}
	$pages = max($pages, 1);
	
	//��1ҳ��ʼ
	$__task__['current_category_page'] = 1;

	if(
		empty($this_module->CONFIG['htmlize']) ||
		($__task__['type'] && $__CAT__['type'] != $__task__['type'])
	)
	{
		//��������ǲ����ɾ�̬��,�����Ͳ�ƥ��,��ǰģ���пɹ��˵��ֶ�,������һ������ȥ
		$__task__['category_offset']++;
		
		//û�з�����,���
		if($__task__['category_offset'] >= $__task__['category_count'] -1) _done();
		
		unset($__task__['current_category_page']);
		
		echo p8lang($P8LANG['cms_item']['htmlize']['list_skip'], $__task__['category_offset'], $__task__['category_count']);
	}
	
	//�����ҳ��
	$__task__['current_category_pages'] = $pages;
	$CACHE->write($SYSTEM, 'html_task', $__task_name__, $__task__, 'serialize');
	
	
	echo poster($__task_name__);
	exit;
}

$__current_category_page__ = $__task__['current_category_page'];


//����һ������ step: 3
for($__i__ = 0; $__i__ < $__perpage__; $__i__++){
	
	//############## ���Ĵ��� ###############{
	
	$__page__ = $page = $__current_category_page__ + $__i__;
	
	$file = p8_html_url($this_module, $__CAT__, 'list', false);
	

	if($file){
		
		$basename = basename($file);
		//ȡ·��
		$path = str_replace($basename, '', $file);
		
		$page_file = preg_replace('/#([^#]+)#/', '\1', $file);
		$no_page = preg_replace('/#([^#]+)#/', '', $file);
		
		if($page == 1){
			//������������{$system_url}/#list-{$page}.html#
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
	//############## ���Ĵ��� ###############}
	
	if($__page__ >= $__task__['current_category_pages']){
		//�������ҳ��,��һ�������������
		$__task__['category_offset']++;
		if($__task__['category_offset'] >= $__task__['category_count']){
			//���з������ɽ���
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

//һ�β�������һ�������ҳ��,��������
$__task__['current_category_page'] = ++$__page__;
$CACHE->write($SYSTEM, 'html_task', $__task_name__, $__task__, 'serialize');

echo poster($__task_name__);

?>