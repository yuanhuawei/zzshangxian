<?php
defined('PHP168_PATH') or die();

/**
 * 所有内容列表
 */

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message("数据不存在！");

	$select = select();
	$select->from("{$this_module->table_subject} AS s", 's.*');
	$select->in('id', $id);
	$subject = $core->select($select,array('single' => true));
	$subject = attachment_url($subject);


	include template($this_module, 'list_full', 'admin');

}else{

	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('数据不存在！');

	if($this_controller->update_subject($_POST))
	message('done',"{$this_url}?id={$id}");
	message('操作失败!');
}

?>