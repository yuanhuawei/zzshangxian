<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'GET'){

	$sid = isset($_GET['sid']) ? $_GET['sid'] : 0;
	if(empty($sid))message('数据不存在!');

	$item = $this_system->load_module('item');

	$select = select();
	$select->from("{$this_module->list_table} AS l",'l.*');
	$select->inner_join("{$item->main_table} AS i",'i.title,i.model,i.cid,i.views,i.comments,i.username,i.verified,i.timestamp','i.id=l.iid');
	$select->inner_join("{$this_module->sort_table} AS s",'s.name','s.id=l.sid');
	$select->in('l.sid',$sid);
	$list = $core->list_item($select);
	
	$select = select();
	$select->from($this_module->sort_table);
	//$select->in('parent',$sid);
	$childs = $core->list_item($select);
	
	$select = select();
	$select->from($this_module->sort_table);
	$select->in('id',$sid);
	$ac = $core->select($select);
	
	include template($this_module, 'list');

}else if(REQUEST_METHOD == 'POST'){

	message('done');

}