<?php
defined('PHP168_PATH') or die();

/**
* ���������б�
**/

//���Ҫ����ϸ��Ȩ����$ACTION,����ϲ�Ȩ����manage
//$this_controller->check_admin_action('manage') or message('no_privilege');
$this_controller->check_admin_action($ACTION) or message('no_privilege');

load_language($core, 'config');

$select = select();
$select->from($this_module->table, '*');

$role = &$core->load_module('role');
$role->get_cache();

$list = $core->list_item($select);

include template($this_module, 'list', 'admin');