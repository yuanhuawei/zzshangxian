<?php
defined('PHP168_PATH') or die();

/**
 * Ìí¼Ó·ÃÌ¸
 */

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	include template($this_module, 'add_subject', 'admin');
}else{
	
	if($this_controller->add_subject($_POST))
	message('done',"{$this_router}-list_subject");
	message('²Ù×÷Ê§°Ü!');
}

?>