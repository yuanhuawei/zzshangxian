<?php
$__FILE__ = __FILE__;

$LABEL_PAGE = 'member';

require_once dirname($__FILE__).'/inc/init.php';

if(empty($core->CONFIG['site_open']) && !$IS_ADMIN){
	//关闭网站,管理员放行
	message($core->CONFIG['site_close_reason']);
}

//用户状态有异常
if(!empty($_P8SESSION['status']) && $_P8SESSION['status'] == 2){
	message('member_locked');
}

//header('Pragma: no-cache');
//header('Cache-Control: no-cache, must-revalidate');

define('P8_MEMBER', true);


if(!$UID){
	
	//if(P8_AJAX_REQUEST){
	//	exit('{}');
	//}else{
		if(HTTP_REFERER != $core->U_controller){
			//如果不是请求/u.php, 设置登录后的跳转
			$forward = HTTP_REFERER;
		}
		
		//更改当前URL路由到登录页面
		//$_SERVER['_REQUEST_URI'] = PHP_SELF .'/core/member-login';
		$_SERVER['_REQUEST_URI'] = P8_ROOT .'u.php/core/member-login';

	//}
}

//获取URL路由
$router = $core->get_router();

$SYSTEM = $MODULE = $script = '';
$ACTION = 'index';
//默认动作index

$URL_PARAMS = array();

if(($count = count($router)) > 0){	//参数大于0
	
	if($action_router = match_action($router[0])){
		//匹配到是系统操作 system-action-...
		$SYSTEM = $action_router[0];
		$ACTION = $action_router[1];
		
		$URL_PARAMS = array_slice($action_router, 2);
	}else{
		
		//匹配到是模块操作 system/module-action-...
		$SYSTEM = $router[0];
		if($count > 1 && $action_router = match_action($router[1])){
			$MODULE = $action_router[0];
			$ACTION = $action_router[1];
			
			$URL_PARAMS = array_slice($action_router, 2);
		}else{
			$MODULE = empty($router[1]) ? '' : $router[1];
		}
		
	}
	
	$ACTION = empty($ACTION) ? 'index' : basename($ACTION);
	
	if($SYSTEM != 'core'){
		if(isset($core->modules[$SYSTEM])){
			//核心模块
			$MODULE = $SYSTEM;
			$SYSTEM = 'core';
		}else if(empty($core->systems[$SYSTEM]['enabled'])){
            header('HTTP/1.1 404 Not Found'); 
			message('no_such_system');
		}
	}
	
	if($SYSTEM == 'core'){
		//如果当前系统是核心
		
		$this_system = &$core;
		
		if($MODULE){
			if(empty($core->modules[$MODULE]['enabled'])) {
                header('HTTP/1.1 404 Not Found'); 
                message('no_such_module');
            }
			
			//核心模块 core/module-action-...
			$this_module = &$core->load_module($MODULE);
			$this_router = $this_module->U_controller;
			$script_path = $this_module->path .'member/';
			
			$this_controller = &$core->controller($this_module);
			
		}else{
			$this_router = $core->U_controller;
			$script_path = $core->path .'member/';
		}
		
		$SKIN = $RESOURCE .'/skin/'. $core->CONFIG['member_template'] .'/'. $this_system->name .'/';
		
	}else{
		//其他系统
		
		$this_system = &$core->load_system($SYSTEM);
		
		if($MODULE){
			if(empty($this_system->modules[$MODULE]['enabled'])) {
                header('HTTP/1.1 404 Not Found'); 
                message('no_such_module');
            }
			
			//模块action system/module-action-...
			$this_module = &$this_system->load_module($MODULE);
			$this_router = $this_module->U_controller;
			$script_path = $this_module->path .'member/';
			
			$this_controller = &$core->controller($this_module);
			
		}else{
			//系统action system-action-...
			$script_path = $this_system->path .'member/';
			$this_router = $this_system->U_controller;
			
			$this_controller = &$core->controller($this_system);
		}
		
		$SKIN = $RESOURCE .'/skin/'. $core->CONFIG['member_template'] .'/'. $this_system->name .'/';
	}
	if(isset($_GET['forward'])){
		$forward = html_entities($_GET['forward']);
	}else if(isset($forward)){
		$forward = html_entities($forward);
	}else{
		$forward = $this_module->U_controller;
	}
	$this_url = $this_router .'-'. $ACTION;
	$script = $script_path . $ACTION .'.php';
	
}else{
	
	//没有任何动作,请求首页
	
	$SYSTEM = 'core';
	$this_system = &$core;
	$this_module = &$core->load_module('member');
	$this_controller = &$core->controller($this_module);
	$script = $this_module->path .'member/index.php';
	$sites_flag = in_array('s.php',explode('/',$HTTP_REFERER)) ? true : false;
    if(!$sites_flag && isset($core->systems['sites'])){
        $sites = &$core->load_system('sites');
        $sites_flag = $sites->check_domain($HTTP_REFERER);
    }
	if($sites_flag) $_GET['main_page'] = '/sites/item-my_list';
	
	$this_url = $core->U_controller;
	$SKIN = $RESOURCE .'/skin/'. $core->CONFIG['member_template'] .'/'. $this_system->name .'/';
	
}

defined('P8_SYSTEM') or define('P8_SYSTEM', $SYSTEM);
defined('P8_MODULE') or define('P8_MODULE', $MODULE);
defined('P8_ACTION') or define('P8_ACTION', $ACTION);

$MEMBERSKIN = $RESOURCE .'/skin/'. $core->CONFIG['member_template'];
//脚本不存在
is_file($script) or message('access_denied');

$LABEL_URL = xss_url($this_url .($URL_PARAMS ? '-'. implode('-', $URL_PARAMS) : '').'?'. $_SERVER['QUERY_STRING']);

if($UID && !get_cookie('USERNAME')){
	set_cookie('USERNAME', jsonencode($USERNAME));
	set_cookie('UID', $UID);
	set_cookie('ROLE', $ROLE);
	$IS_ADMIN && set_cookie('IS_ADMIN', $IS_ADMIN);
}

load_language($this_system, 'global');
if($MODULE) load_language($this_module, 'global');

//插件		插件数据	标签数据
$PLUGIN = $__plugin = $__label = array();

$TEMPLATE = $core->CONFIG['member_template'];

//gzip
if(function_exists('ob_gzhandler') && !empty($core->CONFIG['gzip'])) ob_start('ob_gzhandler');

$menu_flag = false;
if(isset($_GET['main_page'])){
	$_GET['main_page'] = xss_url($_GET['main_page']);
	$menu_flag = in_array('sites',explode('/',$_GET['main_page']));
}

//执行脚本
require $script;



/*
echo 'skin:'.$SKIN;

echo '<pre>';
echo 'script:'.$script.'<br>';
print_r(get_included_files());
echo '<br />';
echo 'Time: '. (get_timer() - $P8['start_time']) .'<br />';
echo 'Memory: '. (memory_usage() - $P8['memory_usage'])/1000 .' KB<br />';
echo 'Querys: '. $core->DB_master->query_num .'<br />';
echo 'UID:'. $UID .'<br />';
echo 'ROLE:'. $core->ROLE .'<br />';
echo 'ROLE_GROUP:'. $ROLE_GROUP .'<br />';
echo 'USERNAME:'. $USERNAME .'<br />';

echo '</pre>';
*/
?>