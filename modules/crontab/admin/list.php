<?php
defined('PHP168_PATH') or die();

/**
* 计划任务列表
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$lock_status = current($CACHE->read('core/modules', 'crontab', 'lock', 'serialize'));
	
	$select = select();
	$select->from($this_module->table, '*');
	$select->order('id DESC');
	$list = $core->list_item($select);
	foreach($list as $k => $v){
		$list[$k]['interval'] = $this_module->run_interval($v);
	}
	
	include template($this_module, 'list', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$CACHE->delete('core/modules', 'crontab', 'lock');
	
	message('done', HTTP_REFERER);
}