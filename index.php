<?php
$__FILE__ = __FILE__;

$LABEL_PAGE = 'front';

require_once dirname($__FILE__).'/inc/init.php';

if(empty($core->CONFIG['site_open']) && !$IS_ADMIN){
	//关闭网站,管理员放行
	message($core->CONFIG['site_close_reason']);
}

if(defined('FROM_MOBILE')){
    if(empty($core->CONFIG['enable_mobile']) && !$IS_ADMIN)message('mobile is no enable', $core->url);
    $core->ismobile = true;
}
if($core->ismobile && !defined('FROM_MOBILE') && !defined('P8_GENERATE_HTML')){
	//$b = substr($_SERVER['_REQUEST_URI'],strpos($_SERVER['_REQUEST_URI'],'index.php'));
	//$url = rtrim($core->murl,'/') .'/' . $b;
	//header("location:$url");
	//exit;
}
//获取URL路由
$router = $core->get_router();
/* if(!$UID && !defined('P8_GENERATE_HTML') && !(!USER_AGENT || SE_ROBOT || isset($_REQUEST['_no_session']))){
	if(REQUEST_METHOD=='AJAX')exit('[]');
	if(!empty($router) && !in_array('member-register',$router)){
		$forward = $router? REQUEST_URI : '';
		unset($router);
	}
}  */
 
$SYSTEM = $MODULE = $script = '';
$ACTION = 'main';
//默认动作index

$URL_PARAMS = array();
$LABEL_POSTFIX=1;
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
	$SYSTEM == '' && $SYSTEM = 'core';
	
	$ACTION = empty($ACTION) ? 'main' : basename($ACTION);
	//不允许访问的ACTION
	$filter = array(
		'system' => 1,
		'module' => 1,
		'controller' => 1,
		'#' => 1
	);
	
	if(!empty($filter[$ACTION])){
        header('HTTP/1.1 404 Not Found'); 
        message('access_denied1');
    }
	// auto_laires();
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
			$this_router = $core->ismobile? $this_module->mobile_controller:$this_module->controller;
			$script_path = $this_module->path;
			
			$TEMPLATE = empty($this_module->CONFIG['template']) ? $core->CONFIG['template'] : $this_module->CONFIG['template'];
			$SKDIR = $RESOURCE .'/skin/'. $TEMPLATE .'/';
			$SKIN = $RESOURCE .'/skin/'. $TEMPLATE .'/'. $this_system->name .'/';
			
		}else{
			
			//注意,根目录任意*.php都是危险的,把根目录的脚本排除
			if(in_array($ACTION, array('u', 'install', 'admin', 'utf8ize', 'plugin'))){
                    header('HTTP/1.1 404 Not Found'); 
                    message('access_denied2');
                }
			
			$this_router = $core->ismobile?$core->mobile_controller:$core->controller;
			$script_path = $core->path;
			
			$TEMPLATE = $core->CONFIG['template'];
			$SKDIR = $RESOURCE .'/skin/'. $TEMPLATE .'/';
			$SKIN = $RESOURCE .'/skin/'. $TEMPLATE .'/'. $this_system->name .'/';
		}
		
	}else{
		//其他系统
		
		$this_system = &$core->load_system($SYSTEM);
		
		if($MODULE){
			if(empty($this_system->modules[$MODULE]['enabled']))  {
                header('HTTP/1.1 404 Not Found'); 
                message('no_such_module');
            }
			
			//模块action system/module-action-...
			$this_module = &$this_system->load_module($MODULE);
			$this_router = $core->ismobile?$this_module->mobile_controller:$this_module->controller;
			$script_path = $this_module->path;
			
			$TEMPLATE = empty($this_module->CONFIG['template']) ? $this_system->CONFIG['template'] : $this_module->CONFIG['template'];
			$SKDIR = $RESOURCE .'/skin/'. $TEMPLATE .'/';
			$SKIN = $RESOURCE .'/skin/'. $TEMPLATE .'/'. $this_system->name .'/';
			
		}else{
			//系统action system-action-...
			
			if($ACTION == 'main' && $core->CONFIG['index_system'] == $SYSTEM && !defined('P8_GENERATE_HTML') && !P8_EDIT_LABEL){
				//请求首页,而且是设置当前系统为首页
				header('Location: '. $core->url);
				exit;
			}
			
			$script_path = $this_system->path;
			$this_router = $core->ismobile?$this_system->mobile_controller:$this_system->controller;
			
			$TEMPLATE = $this_system->CONFIG['template'];
			$SKDIR = $RESOURCE .'/skin/'. $TEMPLATE .'/';
			$SKIN = $RESOURCE .'/skin/'. $TEMPLATE .'/'. $this_system->name .'/';
		}
		
	}
	
	$this_url = $this_router .'-'. $ACTION;
	$script = $script_path . $ACTION .'.php';
	
}else{
	
	//没有任何动作,请求首页
	if(empty($core->CONFIG['index_system'])){
		$SYSTEM = 'core';
		$script = PHP168_PATH .'main.php';
		$this_router = $core->ismobile?$core->mobile_controller:$core->controller;
		$this_url = $core->url;
		$TEMPLATE = $core->CONFIG['template'];
		
	}else{
		//如果设置了选取哪个系统作为首页
		$SYSTEM = $core->CONFIG['index_system'];
		$this_system = &$core->load_system($SYSTEM);
		$this_router = $core->ismobile?$this_system->mobile_controller:$this_system->controller;
		
		$script = $this_system->path .'main.php';
		
		$SKIN = $RESOURCE .'/skin/'. $this_system->CONFIG['template'] .'/'. $this_system->name .'/';
		$TEMPLATE = $this_system->CONFIG['template'];
		$SKDIR = $RESOURCE .'/skin/'. $TEMPLATE .'/';
		$this_url = $this_system->controller;
	}
}

defined('P8_SYSTEM') or define('P8_SYSTEM', $SYSTEM);
defined('P8_MODULE') or define('P8_MODULE', $MODULE);
defined('P8_ACTION') or define('P8_ACTION', $ACTION);

$LABEL_URL = xss_url($this_url .($URL_PARAMS ? '-'. implode('-', $URL_PARAMS) : '').'?'. $_SERVER['QUERY_STRING']);

//脚本不存在
if(!is_file($script)){
    header('HTTP/1.1 404 Not Found'); 
    message('access_denied4');
}

if($UID && !get_cookie('USERNAME')){
	set_cookie('USERNAME', jsonencode($USERNAME));
	set_cookie('UID', $UID);
	set_cookie('ROLE', $ROLE);
	$IS_ADMIN && set_cookie('IS_ADMIN', $IS_ADMIN);
}



load_language($this_system, 'global');

if($MODULE){
	load_language($this_module, 'global');
	$this_controller = &$core->controller($this_module);
}else{
	$this_controller = &$core->controller($this_system);
}

//如果在生成静态,把角色回归到游客
if(defined('P8_GENERATE_HTML')){
	$ROLE = $core->ROLE = $this_system->ROLE = $this_controller->ROLE = $core->CONFIG['guest_role'];
	$UID = $IS_ADMIN = $IS_FOUNDER = 0;
	$ROLE_GROUP = $core->CONFIG['person_role_group'];
	
	//重新初始化权限
	$this_controller->init();
}

//页面缓存参数
$PAGE_CACHE_PARAM = array($this_url);

//插件		插件数据	标签数据
$PLUGIN = $__plugin = $__label = array();

//gzip
if(function_exists('ob_gzhandler') && !empty($core->CONFIG['gzip']) && !defined('P8_GENERATE_HTML')) ob_start('ob_gzhandler');

if(P8_EDIT_LABEL && isset($core->systems['sites']) && !empty($core->systems['sites']['enabled'])){
    if(!$IS_FOUNDER && $SYSTEM!='site')message('no_privilege');
    $site = $core->load_system('sites');
    if(!$IS_FOUNDER && $SYSTEM!='site')
        if(!in_array($site->SITE,$site->get_manage_sites()))
            message('no_privilege');
}

//执行脚本
require $script;

//执行计划任务咯,生成静态时不执行
if(!empty($_GET['show_crontab'])){echo "next_crontab:",date('Y-m-d H:i:s',$core->CONFIG['next_crontab']);}
if(
	!empty($core->CONFIG['next_crontab']) && $core->CONFIG['next_crontab'] < P8_TIME &&
	!defined('P8_CRONTAB') && !defined('P8_GENERATE_HTML')
){
	$crontab = &$core->load_module('crontab');
	$crontab_id = 0;
	require $crontab->path .'inc/run.php';
}

/*echo '<pre>';
echo 'script:'.$script.'<br/>';
print_r(get_included_files());
echo '<br />';
echo 'Time: '. (get_timer() - $P8['start_time']) .'<br />';
echo 'Memory: '. (memory_usage() - $P8['memory_usage'])/1000 .' KB<br />';
echo 'Querys: '. $core->DB_master->query_num .'<br />';
echo 'Uid: '. $UID .'<br />';
echo 'Role: '. $core->ROLE .'<br />';
echo 'Role_gid: '. $ROLE_GROUP .'<br />';
echo '</pre>';*/
?>