<?php
defined('PHP168_PATH') or die();

/**
* ɾ��׷������, ֻ����ajax����, ����ɹ��򷵻ر�ɾ����ҳ��
**/

$this_controller->check_admin_action('delete') or message('[]');

if(REQUEST_METHOD == 'POST'){
	
	$model = isset($_POST['model']) ? $_POST['model'] : '';
	
	$iid = isset($_POST['iid']) ? intval($_POST['iid']) : 0;
	$iid or exit('[]');
	
	$page = isset($_POST['page']) ? (array)$_POST['page'] : array(2);
	
	function _filter($v){
		return $v != 1 && $v;
	}
	//����ɾ����һҳ
	$page = array_filter(array_map('intval', (array)$page), '_filter');
	$page or exit('[]');
	
	$this_module->set_model($model);
	$this_module->delete_addon($iid, $page) or exit('[]');
/**
* your code
**/
	exit(jsonencode($page));
}