<?php

defined('PHP168_PATH') or die();



$this_controller->check_admin_action('client') or exit('[]');



if(REQUEST_METHOD == 'POST'){

	

	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();

	$ids = implode(',', $id);

	$ids or exit('[]');

	

	$this_module->delete(array(

		'where' => 'id IN('. $ids .')'

	));

	

	exit(p8_json($id));

}