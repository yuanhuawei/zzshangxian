<?php
defined('PHP168_PATH') or die();

//if(REQUEST_METHOD == 'POST'){
//余额支付,如果提交到这一步,说明用户已经确定支付
$NO = isset($_POST['order_NO']) ? $this_controller->valid_NO($_POST['order_NO']) : '';

if($this_module->notify('credit', $NO) !== null){
	//验证成功
	/*write_file(CACHE_PATH .'log/credit_notify.php', '<?php exit;?>'. var_export($_POST, true), 'a');*/
	exit('success');
}
//}
exit('fail');