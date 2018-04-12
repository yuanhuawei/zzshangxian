<?php
$__FILE__ = __FILE__;

$LABEL_PAGE = 'admin';

require_once dirname($__FILE__).'/inc/init.php';

//header('Pragma: no-cache');
//header('Cache-Control: no-cache, must-revalidate');

//已经进入后台
define('P8_ADMIN', true);

//要强制进后台把下面一行开头的"//"去掉
//$IS_FOUNDER = 1; $UID = 1; $IS_ADMIN = 1; $_P8SESSION['#admin_login#'] = 1; define('ADMIN_FORCE', true);
if(!empty($core->CONFIG['allow_ip']['enabled'])){
	if(!empty($core->CONFIG['allow_ip']['admin']) && !isset($core->CONFIG['allow_ip']['admin'][P8_IP])) die( "Forbid Ip!!" );
	if(!empty($core->CONFIG['allow_ip']['admin_beginip']) && !empty($core->CONFIG['allow_ip']['admin_endip'])) allow_ip(true);
}
//未登录后台
if(empty($UID) || empty($_P8SESSION['#admin_login#'])){
	
	if(REQUEST_URI != $core->admin_controller){
		//如果不是请求/admin.php, 设置登录后的跳转
		$forward = REQUEST_URI;
	}
	
	//更改当前URL路由到登录页面
	$_SERVER['_REQUEST_URI'] = '/'. $core->admin_controller .'/core-login';
}

//获取数组,如 admin.php/aa/bb形式的URL 以"/"切隔,得数组,如结果是array('aa','bb')
$router = $core->get_router();

$this_router = $core->admin_controller;
$URL_PARAMS = array();


$SYSTEM = $MODULE = $SCRIPT = '';
$ACTION = 'index';
//默认动作index

$P8_ROOT = P8_ROOT;
$SKIN = $RESOURCE .'/skin/admin';

if(($count = count($router)) > 0){	//参数大于0
	
	if($action_router = match_action($router[0])){
		//匹配到的URL,如admin.php/core-config,而非admin.php/core/member-config
		$SYSTEM = $action_router[0];
		$ACTION = $action_router[1];
		$URL_PARAMS = array_slice($action_router, 2);
	}else{
		//匹配到的URL,如admin.php/core/member-config,而非admin.php/core-config
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
		//如果这系统不存在,也不是核心
        header('HTTP/1.1 404 Not Found'); 
		message('access_denied');
	}
	
	$ACTION = empty($ACTION) ? 'index' : basename($ACTION);
	
	$this_router .= '/'. $SYSTEM;
	
	if($SYSTEM == 'core'){
		$this_system = &$core;
		//核心系统
		if($MODULE){	//匹配URL格式admin.php/core/member-config
			if(!isset($core->modules[$MODULE])) {
                header('HTTP/1.1 404 Not Found'); 
                message('no_such_module');
            }
			
			$this_module = &$core->load_module($MODULE);
			$this_router .= '/'. $MODULE;
			$script_path = $this_module->path .'admin/';
			
		}else{	//匹配URL格式admin.php/core-config
			
			$script_path = $core->path .'admin/';
			
		}
		
		$_SKIN = $SKIN .'/core';
		
	}else{
		//子系统
		$this_system = &$core->load_system($SYSTEM);
		
		if($MODULE){	//匹配URL格式admin.php/cms/member-config
			//模块操作
			if(!isset($this_system->modules[$MODULE])) {
                header('HTTP/1.1 404 Not Found'); 
                message('no_such_module');
            }
			
			$this_module = &$this_system->load_module($MODULE);
			$this_router .= '/'. $MODULE;
			$script_path = $this_module->path .'admin/';
			
		}else{	//匹配URL格式admin.php/cms-config
			//系统操作
			$script_path = $this_system->path .'admin/';
			
			
		}
		
		$_SKIN = $SKIN .'/'. $SYSTEM;
	}
	
	$this_url = $this_router .'-'. $ACTION;
	$script = $script_path . $ACTION .'.php';
	
}else{
	
	$SYSTEM = 'core';
	$this_system = &$core;
	$script = PHP168_PATH .'admin/index.php';
	$this_url = $this_router;
	
}

defined('P8_SYSTEM') or define('P8_SYSTEM', $SYSTEM);
defined('P8_MODULE') or define('P8_MODULE', $MODULE);
defined('P8_ACTION') or define('P8_ACTION', $ACTION);

$LABEL_URL = xss_url($this_url .($URL_PARAMS ? '-'. implode('-', $URL_PARAMS) : '').'?'. $_SERVER['QUERY_STRING']);

is_file($script) or message('access_denied');

//加载语言包
load_language($core, 'admin');	
load_language($this_system, 'global');
load_language($this_system, 'admin');

if($MODULE){
	load_language($this_module, 'global');
	load_language($this_module, 'admin');
	
	$this_controller = &$core->controller($this_module);
}else{
	$this_controller = &$core->controller($this_system);
}

$TEMPLATE = 'admin';

if(function_exists('ob_gzhandler') && !empty($core->CONFIG['gzip'])) ob_start('ob_gzhandler');

//日志
function admin_log(){
	if(defined('NO_ADMIN_LOG')) return;
	if(REQUEST_METHOD != 'POST') return;
	
	global $UID, $USERNAME, $core, $SYSTEM, $MODULE, $ACTION, $ADMIN_LOG, $P8LANG;
	
	$datelong = 30;
	
	if($SYSTEM == 'core' && $MODULE == 'cluster') return;
	
	if(empty($ADMIN_LOG)){
		if($MODULE){
			if(!empty($P8LANG['_module_'. $ACTION .'_admin_log']))
				$ADMIN_LOG = array('title' => $P8LANG['_module_'. $ACTION .'_admin_log']);
			else
				$ADMIN_LOG = array('title' => '_module_'. $ACTION .'_admin_log');
		}else if($SYSTEM && $SYSTEM != 'core'){
			if(!empty($P8LANG['_system_'. $ACTION .'_admin_log']))
				$ADMIN_LOG = array('title' => $P8LANG['_system_'. $ACTION .'_admin_log']);
			else
				$ADMIN_LOG = array('title' => '_system_'. $ACTION .'_admin_log');	
		}else{
			if(!empty($P8LANG['_core_'. $ACTION .'_admin_log']))
				$ADMIN_LOG = array('title' => $P8LANG['_core_'. $ACTION .'_admin_log']);
			else
				$ADMIN_LOG = array('title' => '_core_'. $ACTION .'_admin_log');	
		}
	}
	
	$_POST = array_merge(array('__referer' => HTTP_REFERER), $_POST);
    if(isset($_POST['password']))$_POST['password']='******';
	$ADMIN_LOG = array_merge($ADMIN_LOG, array(
		'uid' => $UID,
		'username' => $USERNAME,
		'url' => $_SERVER['_REQUEST_URI'],
		'data' => $core->DB_master->escape_string(var_export($_POST, true)),
		'ip' => P8_IP,
		'timestamp' => P8_TIME
	));
	
	$core->DB_master->insert(
		$core->TABLE_ .'admin_log',
		$ADMIN_LOG
	);
	
	$datelong && $core->DB_master->delete(
		$core->TABLE_ .'admin_log',
		'timestamp < '. (P8_TIME - $datelong * 86400)
	);
}

//退后出记录日志
register_shutdown_function('admin_log');

$BACKTO_ALL_CACHE = <<<EOT
<form id="_all_cache_" method="post" action="{$core->admin_controller}/core-cache">
<input type="hidden" name="start" value="1" />
</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById('_all_cache_').submit(); }, 1);
</script>
EOT;

//执行脚本
require $script;



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