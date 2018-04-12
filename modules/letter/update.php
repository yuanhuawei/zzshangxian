<?php
defined('PHP168_PATH') or die();

/**
* 添加模型内容入口文件
**/


if(REQUEST_METHOD == 'GET' || defined('P8_GENERATE_HTML')){
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $P8LANG['letter'] .'_'. $core->CONFIG['site_name'];
	
	$id=intval($_GET['id']);
	if(!$id)
		message('error');

	$id_type = $this_module->id_type();
	$data = $this_module->getData($id);
	if($data['uid']!=$UID)message('no_privilege');
		
	!empty($data['attachment']) && $data['attachment']= attachment_url($data['attachment']);
	
	$cates = $this_module->get_category();
	$attachment_hash = unique_id(16);
	include template($this_module, 'edit');

}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	$data = $this_module->getData(intval($_POST['id']));
	if($data['uid']!=$UID)message('no_privilege');
	$status = $this_controller->update($_POST) or message('fail');
	
	unset($_POST);
	$message = $P8LANG['edit_success'];
	$reurl = $this_url.'?id='.$status['id'];
	include template($this_module, 'message');		
}