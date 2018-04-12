<?php
defined('PHP168_PATH') or die();

//检查当前动作权限
$this_controller->check_action($ACTION) or message('no_privilege');
$this_controller->check_category_action($ACTION, intval($_POST['cid'])) or message('no_category_privilege');
if(REQUEST_METHOD == 'POST'){
	$_POST = p8_stripslashes2($_POST);
    if(isset($_POST['checkcaptcha'])){
		$st = !captcha(isset($_POST['captcha']) ? $_POST['captcha'] : '',true)?'false':'true';
		exit($st);
	}
    if($this_system->CONFIG['captcha'] && !captcha($_POST['captcha']))message('captcha_incorrect', HTTP_REFERER, 10);
	$this_controller->post($_POST) or message('ask_error', HTTP_REFERER, 3);

}else{
	message('ask_error');
}