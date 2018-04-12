<?php
@set_time_limit(0);
@ignore_user_abort(false);

//定义生成静态的常量
define('P8_GENERATE_HTML', true);
//不产生日志
define('NO_ADMIN_LOG', true);

require_once PHP168_PATH .'inc/html.func.php';

global $this_model, $MODEL, $HTML_DATA;
foreach(array_keys($GLOBALS) as $v){
    global $$v;
}

$__task__ = array();
$__task__['mobile'] = $mobile?true:false;
//页数
$__perpage__ = isset($this->system->CONFIG['html_list_size'])?intval($this->system->CONFIG['html_list_size']):5;
if(!$__perpage__)return;
//获取分类信息
$__CAT__ = $this->system->fetch_category($dcid);
$__CAT__['is_category'] = true;
$model = $this->system->get_model($__CAT__['model']);
		
if(
    empty($__CAT__['htmlize']) || $__CAT__['htmlize'] == 2 ||
    ($__CAT__['type'] == 2 && !empty($model['filterable_fields']))
){
    
    return;
}
		
		
//分类的页数
//如果是大分类,只生成封面页就可以了,或者仅生成第一页
if($__CAT__['type'] == 1 && !$__CAT__['list_all_model']){
    $pages = 1;
}else{
    $_pages = ceil($__CAT__['item_count'] / $__CAT__['page_size']);
    $pages = $__perpage__> $_pages? $_pages :$__perpage__;
}
$pages = max($pages, 1);
$pages = min($pages, 10);
//第1页开始
$__task__['current_category_page'] = 1;

//分类的页数
$__task__['current_category_pages'] = $pages;

        
        
        
//生成一个分类 step: 3{
for($__i__ = 0; $__i__ < $__perpage__; $__i__++){

	
	//############## 核心代码 ###############{
	$__page__ = $page = $__task__['current_category_page'] + $__i__;
    if($__task__['mobile']){
	    $__CAT__['html_list_url_rule'] = $__CAT__['html_list_url_rule_mobile'];
	}
	//很危险的啦,你懂的啦
	$__CAT__['html_list_url_rule'] = str_replace('"', '', $__CAT__['html_list_url_rule']);
	$__file__ = p8_html_url($this, $__CAT__, 'list', false);
	
	if($__file__){
		
		$this->_html['basename'] = basename($__file__);
		//取路径
		$this->_html['path'] = str_replace($this->_html['basename'], '', $__file__);
		
		$page_file = preg_replace('/#([^#]+)#/', '\1', $__file__);
		$no_page = preg_replace('/#([^#]+)#/', '', $__file__);
		
		if($page == 1){
			//如果是这种情况{$system_url}/#list-{$page}.html#, 第一页使用一个index.$ext来作索引页
			if(preg_match('/^#.*\.(.*)#$/', $this->_html['basename'], $m)){
				$this->_html['file'] = $this->_html['path'] .'index.'. $m[1];
			}else{
				$this->_html['file'] = $no_page;
			}
		}else{
			$this->_html['file'] = str_replace('?page?', $page, $page_file);
		}
		if($__task__['mobile']){
			$__list_uri__ = '/m/index.php/'. $SYSTEM .'/item-list-category-{$dcid}-page-{$page}';
			$filename = PHP168_PATH .'m/index.php';
		}else{
			$__list_uri__ = '/index.php/'. $SYSTEM .'/item-list-category-{$dcid}-page-{$page}';
			$filename = PHP168_PATH .'index.php';
		}
		eval('$_SERVER[\'_REQUEST_URI\'] = "'. $__list_uri__ .'";');
		
		
		ob_start();
		require $filename;
		$__content__ = ob_get_clean();
		
		md($this->_html['path']);
		if(!write_file($this->_html['file'], $__content__)){
			message(p8lang($P8LANG['cms_item_html_unwritable'], array($this->_html['file'])));
		}
		@chmod($this->_html['file'], 0644);
	}
	//############## 核心代码 ###############}
	
	if($__page__ >= $__task__['current_category_pages'])return;
	
}