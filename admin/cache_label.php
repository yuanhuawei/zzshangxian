<?php
defined('PHP168_PATH') or die();

/**
* ¸üÐÂ»º´æ
**/

//var_dump($ACTION);
$this_controller->check_admin_action($ACTION) or message('no_privilege');
@set_time_limit(0);
@ignore_user_abort(true);
load_language($core, 'config');
require_once PHP168_PATH .'inc/cache.func.php';
cache_label();
message('done');