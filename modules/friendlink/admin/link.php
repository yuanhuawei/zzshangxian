<?php
defined('PHP168_PATH') or die();

/**
 * 友情链接列表
 */

$this_controller->check_admin_action('link') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	
	$select = select();
	$select->from("{$this_module->table_link} AS l", 'l.*');
	$select->inner_join("{$this_module->table_sort} AS s", 's.name sname', 'l.fid=s.fid');
	$select->order('l.list DESC');
	$links = $core->list_item($select);
	foreach($links as $key => $detail){
		$links[$key]['logo'] = attachment_url($detail['logo']);
	}
	include template($this_module, 'friendlink', 'admin');
	
}else if(REQUEST_METHOD=='POST'){
	$list=array_map('intval',(array)$_POST['list']);
	$this_controller->update_list($list);
	message('done');
}

?>