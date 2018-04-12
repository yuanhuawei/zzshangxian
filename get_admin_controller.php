<?php
defined('PHP168_PATH') or die();

/**
* 供前台有权限的返回后台入口,JSONP形式,可以跨域
**/

$IS_ADMIN or exit('');

//HTTP_REFERER;

exit(isset($_GET['callback']) ? $_GET['callback'] .'("'. $core->CONFIG['admin_controller'] .'")' : '');