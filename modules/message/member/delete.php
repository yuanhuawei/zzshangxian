<?php
defined('PHP168_PATH') or die();

/**
 * 删除消息,POST提供ajax调用,GET提供批量删除功能
 **/

if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');

	$type = isset($_POST['type']) && $_POST['type'] == 'out' ? 'out' : 'in';
	$and = ' AND '. ($type == 'in' ? 'sendee_uid' : 'sender_uid') .' = \''. $UID .'\'';

	//只能删除自己的
	if(
		$this_module->delete(array(
			'where' => "id IN (". implode(',', $id) .")$and"
		))
	){
		exit(jsonencode($id));
	}
	
}

exit('[]');