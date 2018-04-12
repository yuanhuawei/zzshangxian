<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('edit') or die();

if(!P8_AJAX_REQUEST || REQUEST_METHOD == 'GET'){
	die();
}

$json = $this_controller->set_best_answer($_POST);
echo jsonencode($json);
exit;