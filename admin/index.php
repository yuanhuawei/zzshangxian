<?php
defined('PHP168_PATH') or die();

header('Pragma: no-cache');

$IS_ADMIN or message('no_privilege');

require_once PHP168_PATH .'admin/inc/menu.class.php';


$core->get_cache('role');
	
$admin_menu->get_cache();

//�˵�JSON
$json = $CACHE->read('', 'core', 'admin_menu_json');

//����ֹ�Ĳ˵�,��ʼ�˿��Բ鿴���в˵�
$denied = $IS_FOUNDER ? '{}' : $CACHE->read('', 'core', 'admin_menu_role_'. $core->ROLE);

include template($core, 'index', 'admin');
exit;