<?php
defined('PHP168_PATH') or die();

/**
* 插件管理的入口
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';

if(empty($core->plugins[$plugin])) message('no_such_plugin');

//加载插件
$this_plugin = &$core->load_plugin($plugin);
$this_plugin or message('no_such_plugin');

//选择插件动作
$action = isset($_REQUEST['action']) ? basename($_REQUEST['action']) : '';
$action = empty($action) ? 'index' : $action;

is_file($this_plugin->path .'admin/'. $action .'.php') or message('access_denied');

$_this_url = $this_url .'?plugin='. $plugin;

//执行脚本
require $this_plugin->path .'admin/'. $action .'.php';