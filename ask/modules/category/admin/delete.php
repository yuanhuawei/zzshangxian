<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or die();

if(!P8_AJAX_REQUEST || REQUEST_METHOD == 'GET'){
	die();
}

$this_module->cache(false, false);

$ids_arr = array();

$ids_arr = $this_controller->delete($_POST);
if(!empty($ids_arr)){
	//��������ģ��
	$item = &$this_system->load_module('item');
	$item_controller = &$core->controller($item);
	//�����Աģ��
	$ask_m = &$this_system->load_module('member');
	$ask_m_controller = &$core->controller($ask_m);
	
	//ɾ������ר��
	$ask_m_controller->delete_expertor(array('cids'=>$ids_arr));

}

echo jsonencode($ids_arr);
exit;