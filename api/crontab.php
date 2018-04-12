<?php
require dirname(__FILE__) .'/../inc/init.php';

//执行计划任务咯,生成静态时不执行
if(
	!empty($core->CONFIG['next_crontab']) && $core->CONFIG['next_crontab'] < P8_TIME &&
	!defined('P8_CRONTAB') && !defined('P8_GENERATE_HTML') &&
	!$core->ismobile
){
	echo 'var contab_begig="'.date('Y-m-d H:i:s').'"';
	$crontab = &$core->load_module('crontab');
	$crontab_id = 0;
	require $crontab->path .'inc/run.php';
	echo 'var contab_finish="'.date('Y-m-d H:i:s').'"';
}
echo 'var contrab=1;';