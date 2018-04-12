<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or die();

P8_AJAX_REQUEST or die();

$id = $this_controller->post_reply_follow($_POST) or die();
echo jsonencode($id);
exit;