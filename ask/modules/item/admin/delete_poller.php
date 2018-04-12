<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(!P8_AJAX_REQUEST || REQUEST_METHOD == 'GET') message('ask_error');

$json = $this_controller->delete_poller($_POST) or die();
echo jsonencode($json);
exit;
