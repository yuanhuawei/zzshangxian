<?php
defined('PHP168_PATH') or die();

/**
* ����ģ��
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$this_module->cache();
	//�����ܻ���
	!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);
	message('done');
}