<?php
defined('PHP168_PATH') or die();

/**
 * ɾ����Ϣ,POST�ṩajax����,GET�ṩ����ɾ������
 **/

if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');

	$type = isset($_POST['type']) && $_POST['type'] == 'out' ? 'out' : 'in';
	$and = ' AND '. ($type == 'in' ? 'sendee_uid' : 'sender_uid') .' = \''. $UID .'\'';

	//ֻ��ɾ���Լ���
	if(
		$this_module->delete(array(
			'where' => "id IN (". implode(',', $id) .")$and"
		))
	){
		exit(jsonencode($id));
	}
	
}

exit('[]');