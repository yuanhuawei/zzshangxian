<?php
defined('PHP168_PATH') or die();

/**
* ɾ������,ֻ�ṩAJAX����
**/

if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$system = isset($_POST['system']) ? $_POST['system'] : '';
	//ϵͳ������
	if($system != 'core' && !get_system($system)) exit('[]');
	
	$this_module->set($system);
	
	$this_module->delete(array(
		'where' => 'id IN ('. implode(',', $id) .') AND '. ($UID ? 'uid = \''. $UID .'\'' : 'uid = 0 AND ip = \''. P8_IP .'\'')
	)) or exit('[]');
	
	exit(p8_json($id));
}
exit('[]');