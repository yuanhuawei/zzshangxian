<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or die("['no_privilege']");

P8_AJAX_REQUEST or die();

$id = $this_controller->post_follow($_POST) or die("['error']");
echo jsonencode($id);
exit;