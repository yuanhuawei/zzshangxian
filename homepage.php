<?php
$__FILE__ = __FILE__;
header('HTTP/1.1 404 Not Found'); 
define('P8_PAGE', 'homepage');

require_once dirname($__FILE__).'/inc/init.php';

if(empty($core->CONFIG['site_open']) && !$IS_ADMIN){
	//关闭网站,管理员放行
	message($core->CONFIG['site_close_reason']);
}

//if(empty($core->CONFIG['homepage']['enabled'])) message('access_denied');

define('P8_HOMEPAGE', true);

if(isset($_GET['uid'])){
$meminfo = get_member(intval($_GET['uid']),false,'id');
$_USERNAME = $meminfo['username'];
}

if(isset($_USERNAME)){
	
}else{
	$_USERNAME = '';
	if(!empty($core->CONFIG['homepage']['sub_domain'])){
		if(($dot_count = substr_count($_SERVER['HTTP_HOST'], '.')) > 1){
			$_USERNAME = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.'));
		}
	}else{
		
		//提取用户名
		$uri = $_SERVER['_REQUEST_URI'];
		$self = basename($__FILE__);
		$uri = substr(preg_replace('|^/.*'. $self .'|', '', $uri), 1);
		$s = explode('/', $uri, 2);
		$_USERNAME = $s[0];
		$_SERVER['_REQUEST_URI'] = '/'. $self .(isset($s[1]) ? '/'. $s[1] : '');
	}
}

$_USERNAME = $_USERNAME ? $_USERNAME : $USERNAME;
$_USERNAME or message('no_such_user');

$USER = get_member($_USERNAME);
$USER or message('no_such_user');

$URL = homepage_url($_USERNAME);

$router = $core->get_router();

$IS_HOST = $UID == $USER['id'];


$SYSTEM = $MODULE = $script = '';
$ACTION = 'main';
$SKIN = $RESOURCE .'/skin/'. $core->CONFIG['homepage_template'];
$URL_PARAMS = array();

if(($count = count($router)) > 0){
	if($action_router = match_action($router[0])){
		//匹配到是系统操作 system-action-...
		$SYSTEM = $action_router[0];
		$ACTION = $action_router[1];
		
		$URL_PARAMS = array_slice($action_router, 2);
		if($SYSTEM == '') $SYSTEM = 'core';
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
	
	if($SYSTEM != 'core' && !isset($core->systems[$SYSTEM])){
		if(isset($core->modules[$SYSTEM])){
			$MODULE = $SYSTEM;
			$SYSTEM = 'core';
		}else{
			//如果这系统不存在,也不是核心
			message('access_denied');
		}
	}
	
	if($SYSTEM == 'core'){
		//如果当前系统是核心
		
		$this_system = &$core;
		
		if($MODULE){
			if(empty($core->modules[$MODULE]))
				message('no_such_module');
			
			//核心模块 core/module-action-...
			$this_module = &$core->load_module($MODULE);
			$this_router = $URL .'/'. $MODULE;
			$script_path = $this_module->path .'homepage/';
			
		}else{
			$script_path = $core->path .'homepage/';
			$this_router = $URL;
		}
		
		$_SKIN = $SKIN .'/core';
		
	}else{
		//其他系统
		
		$this_system = &$core->load_system($SYSTEM);
		
		if($MODULE){
			if(empty($this_system->modules[$MODULE]))	//模块不存在
				message('no_such_module');
			
			//模块action system/module-action-...
			$this_module = &$this_system->load_module($MODULE);
			$this_router = $URL . $SYSTEM .'/'. $MODULE;
			$script_path = $this_module->path .'homepage/';
			
		}else{
			//系统action system-action-...
			$script_path = $this_system->path .'homepage/';
			$this_router = $URL . $SYSTEM;
		}
		
		$_SKIN = $SKIN .'/'. $SYSTEM;
		
	}
	
	$this_url = $this_router .'-'. $ACTION;
	$script = $script_path . $ACTION .'.php';
	
}else{
	
	//首页
	$script = $core->path .'homepage/main.php';
	$this_system = &$core;
	$TEMPLATE = $core->CONFIG['homepage_template'];
	
	$this_url = $this_router = $URL;
	
	$SYSTEM = 'core';
}

is_file($script) or message('access_denied');

$LABEL_URL = xss_url($this_url .($URL_PARAMS ? '-'. implode('-', $URL_PARAMS) : '').'?'. $_SERVER['QUERY_STRING']);

load_language($this_system, 'global');
if($MODULE) load_language($this_module, 'global');

$TEMPLATE = $core->CONFIG['homepage_template'];
$PAGE_CACHE_PARAM = array($this_url);
$PAGE_CACHE_PARAM['username'] = $_USERNAME;


$MENU = $CACHE->read('', 'core', 'homepage_menu', 'serialize');
$homepage = $core->load_module('homepage');
$MENU['top_menus'] = $homepage->format_menu($MENU['top_menus'],$USER);

if(function_exists('ob_gzhandler') && !empty($core->CONFIG['gzip'])) ob_start('ob_gzhandler');

require $script;



/*
echo '<pre>';
echo 'script:'.$script.'<br/>';
print_r(get_included_files());
echo '<br />';
echo 'Time: '. (get_timer() - $P8['start_time']) .'<br />';
echo 'Memory: '. (memory_usage() - $P8['memory_usage'])/1000 .' KB<br />';
echo 'Querys: '. $core->DB_master->query_num .'<br />';
echo 'Uid: '. $UID .'<br />';
echo 'Role: '. $core->ROLE .'<br />';
echo 'Role_gid: '. $ROLE_GROUP .'<br />';
echo '</pre>';
*/
?>