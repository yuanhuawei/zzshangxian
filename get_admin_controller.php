<?php
defined('PHP168_PATH') or die();

/**
* ��ǰ̨��Ȩ�޵ķ��غ�̨���,JSONP��ʽ,���Կ���
**/

$IS_ADMIN or exit('');

//HTTP_REFERER;

exit(isset($_GET['callback']) ? $_GET['callback'] .'("'. $core->CONFIG['admin_controller'] .'")' : '');