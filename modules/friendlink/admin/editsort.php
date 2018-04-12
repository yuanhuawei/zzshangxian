<?php
defined('PHP168_PATH') or die();

/**
 * 修改友情链接分类
 **/

$this_controller->check_admin_action('sort') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$fid = isset($_GET['fid']) ? intval($_GET['fid']) : 0;
	if(empty($fid)) message('error');

	$select = select();
	$select->from($this_module->table_sort);
	$select->in('fid', $fid);
	$sort = $core->select($select,array('single'=>1));

	include template($this_module, 'sort_edit', 'admin');

}else if(REQUEST_METHOD == 'POST'){

	if($this_controller->update_sort($_POST)){
		
		message('done',"{$this_router}-sort");
	}else{
		message('fail');
	}
}