<?php
defined('PHP168_PATH') or die();

/**
* ɾ������ҳ
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

	GetGP(array('id'));
	$this_controller->delete($id);
	
	message('done',$from_url);
