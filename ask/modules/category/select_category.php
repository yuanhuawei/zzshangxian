<?
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

P8_AJAX_REQUEST or message('ask_error');

include template($this_module, 'select_category');
exit;