<?php
defined('PHP168_PATH') or die();

/**
* �༭ģ��
**/

$this_controller->check_admin_action('template') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	write_file(CACHE_PATH.'deny_edit_template', ' ');
}