<?php
defined('PHP168_PATH') or die();

/**
* ¶©µ¥ÏêÏ¸
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$NO = isset($_GET['NO']) ? $this_controller->valid_NO($_GET['NO']) : '';
($id || $NO) or message('no_such_item');

$select = select();
$select->from($this_module->order_table .' AS o', 'o.*');
$select->left_join($this_module->lock_table .' AS l', 'l.update_status, l.notify_status, l.id AS lid', 'o.NO = l.NO');
if($NO){
	$select->in('o.NO', $NO);
}else{
	$select->in('o.id', $id);
}
$data = $core->select($select, array('ms' => 'master', 'single' => true));
$data or message('no_such_item');

$data['notify'] = mb_unserialize($data['notify']);


include template($this_module, 'view_order', 'admin');