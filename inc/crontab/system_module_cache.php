<?php
defined('PHP168_PATH') or die();

/**
* ¸üÐÂ²Ëµ¥»º´æ
**/

$_crontab = $crontab;
require_once PHP168_PATH .'inc/cache.func.php';
cache_system_module();
if(!$crontab)$crontab=$_crontab;