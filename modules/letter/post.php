<?php
defined('PHP168_PATH') or die();

/**
* 添加模型内容入口文件
**/

$this_controller->check_action($ACTION) or message('no_privilege');


if(REQUEST_METHOD == 'GET' || defined('P8_GENERATE_HTML')){
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $P8LANG['letter'] .'_'. $core->CONFIG['site_name'];
	
	$data['department'] = isset($_GET['department'])? intval($_GET['department']):'';
	$cates = $this_module->get_category();
	if(!empty($this_module->CONFIG['redepartment'])){
		unset($cates['department'][$this_module->CONFIG['redepartment']]);
	}
	$id_type = $this_module->id_type();
	$attachment_hash = unique_id(16);
	
	$letterconfig = $core->get_config('core', 'letter');
	$tatistics = $this_module->getstatistics2();
	
	include template($this_module, 'edit');

}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	if(isset($_POST['checkcaptcha'])){
		$st = !captcha(isset($_POST['captcha']) ? $_POST['captcha'] : '',true)?'false':'true';
		exit($st);
	}
	$id = $_POST['id'];
	$status = $this_controller->add($_POST) or message('fail');
	unset($_POST);
	$message = p8lang($P8LANG['post_success'], $status['number'],$status['code']);
	$reurl = $this_url;
	include template($this_module, 'message');	
}