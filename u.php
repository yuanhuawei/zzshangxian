<?php
$__FILE__ = __FILE__;

$LABEL_PAGE = 'member';

require_once dirname($__FILE__).'/inc/init.php';

if(empty($core->CONFIG['site_open']) && !$IS_ADMIN){
	//�ر���վ,����Ա����
	message($core->CONFIG['site_close_reason']);
}

//�û�״̬���쳣
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
			//�����������/u.php, ���õ�¼�����ת
			$forward = HTTP_REFERER;
		}
		
		//���ĵ�ǰURL·�ɵ���¼ҳ��
		//$_SERVER['_REQUEST_URI'] = PHP_SELF .'/core/member-login';
		$_SERVER['_REQUEST_URI'] = P8_ROOT .'u.php/core/member-login';

	//}
}

//��ȡURL·��
$router = $core->get_router();

$SYSTEM = $MODULE = $script = '';
$ACTION = 'index';
//Ĭ�϶���index

$URL_PARAMS = array();

if(($count = count($router)) > 0){	//��������0
	
	if($action_router = match_action($router[0])){
		//ƥ�䵽��ϵͳ���� system-action-...
		$SYSTEM = $action_router[0];
		$ACTION = $action_router[1];
		
		$URL_PARAMS = array_slice($action_router, 2);
	}else{
		
		//ƥ�䵽��ģ����� system/module-action-...
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
			//����ģ��
			$MODULE = $SYSTEM;
			$SYSTEM = 'core';
		}else if(empty($core->systems[$SYSTEM]['enabled'])){
            header('HTTP/1.1 404 Not Found'); 
			message('no_such_system');
		}
	}
	
	if($SYSTEM == 'core'){
		//�����ǰϵͳ�Ǻ���
		
		$this_system = &$core;
		
		if($MODULE){
			if(empty($core->modules[$MODULE]['enabled'])) {
                header('HTTP/1.1 404 Not Found'); 
                message('no_such_module');
            }
			
			//����ģ�� core/module-action-...
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
		//����ϵͳ
		
		$this_system = &$core->load_system($SYSTEM);
		
		if($MODULE){
			if(empty($this_system->modules[$MODULE]['enabled'])) {
                header('HTTP/1.1 404 Not Found'); 
                message('no_such_module');
            }
			
			//ģ��action system/module-action-...
			$this_module = &$this_system->load_module($MODULE);
			$this_router = $this_module->U_controller;
			$script_path = $this_module->path .'member/';
			
			$this_controller = &$core->controller($this_module);
			
		}else{
			//ϵͳaction system-action-...
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
	
	//û���κζ���,������ҳ
	
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
//�ű�������
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

//���		�������	��ǩ����
$PLUGIN = $__plugin = $__label = array();

$TEMPLATE = $core->CONFIG['member_template'];

//gzip
if(function_exists('ob_gzhandler') && !empty($core->CONFIG['gzip'])) ob_start('ob_gzhandler');

$menu_flag = false;
if(isset($_GET['main_page'])){
	$_GET['main_page'] = xss_url($_GET['main_page']);
	$menu_flag = in_array('sites',explode('/',$_GET['main_page']));
}

//ִ�нű�
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