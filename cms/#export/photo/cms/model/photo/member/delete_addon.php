<?php
/**
* ɾ��׷������, ֻ����ajax����, ����ɹ��򷵻ر�ɾ����ҳ��
**/

defined('PHP168_PATH') or die();

$this_controller->check_action('delete') or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or exit('0');
	
	$page = isset($_POST['page']) ? $_POST['page'] : 2;
	
	function _filter($v){
		return $v != 1 && $v;
	}
	//����ɾ����һҳ
	$page = array_filter(array_map('intval', (array)$page), '_filter');
	$page or exit('0');
	
	$this_module->delete_addon($id, $page) or exit('0');
/**
* your code
**/
	exit(jsonencode($page));
}