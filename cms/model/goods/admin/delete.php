<?php
defined('PHP168_PATH') or die();

/**
* ɾ������, ֻ����AJAX����, �ɹ����ر�ɾ����ID
**/

$this_controller->check_action($ACTION) or message('no_privilege');


if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$verified = empty($_POST['verified']) ? false : true;
	
	$T = $verified ? $this_module->main_table : $this_module->unverified_table;
	
	$this_module->delete(array(
		'where' => $T .'.id IN ('. implode(',', $id) .')',
		'verified' => $verified
	)) or exit('[]');
/**
* your code
**/
	exit(jsonencode($id));
}