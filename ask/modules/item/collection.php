<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or die();

if(!P8_AJAX_REQUEST || REQUEST_METHOD == 'GET') die();

$json = $this_controller->collection($_POST) or die();
echo jsonencode($json);
exit;