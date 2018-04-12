<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

if(empty($UID)){
	message('not_login');
}

include template($this_module, 'my_home');