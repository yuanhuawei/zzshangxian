<?php
defined('PHP168_PATH') or die();

/**
* 积分类型列表
**/

//如果要很详细的权限用$ACTION,如果合并权限用manage
//$this_controller->check_admin_action('manage') or message('no_privilege');
$this_controller->check_admin_action($ACTION) or message('no_privilege');

load_language($core, 'config');

$select = select();
$select->from($this_module->table, '*');

$role = &$core->load_module('role');
$role->get_cache();

$list = $core->list_item($select);

include template($this_module, 'list', 'admin');