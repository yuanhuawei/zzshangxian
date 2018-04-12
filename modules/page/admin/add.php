<?php
defined('PHP168_PATH') or die();

/**
* Ìí¼Ó¶ÀÁ¢Ò³
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$rsdb['type']='0';
	$rsdb['tpl_main']='page';
	$rsdb['template']=$this_controller->get_templatestyle();
	
	$ext = empty($core->CONFIG['ssi']) ? 'html' : 'shtml';
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$back = $this_router.'-list';
	$_POST = p8_stripslashes2($_POST);
	
	$this_controller->add($_POST);

	message('done', $back );
}