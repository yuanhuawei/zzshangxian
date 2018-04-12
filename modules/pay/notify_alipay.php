<?php
if(defined('PHP168_PATH')){
	
	if(REQUEST_METHOD == 'POST'){
		//exit('success');
		
		//支付宝传回来的订单编号,只支付POST方式
		$NO = isset($_POST['out_trade_no']) ? $this_controller->valid_NO($_POST['out_trade_no']) : '';
		$NO or exit('fail');
		
		if($ret = $this_module->notify('alipay', $NO) !== null){
			//验证成功
			write_file(CACHE_PATH .'log/notify_alipay.php', '<?php exit;?>'. var_export($_POST, true) . serialize($ret), 'a');
			ob_end_clean();
			
			exit('success');
		}
	}
	
	exit('fail');
	
}else{
	
	ob_start();
	
	$_REQUEST['_no_session'] = 1;
	$_SERVER['_REQUEST_URI'] = '/index.php/pay-notify_alipay';
	require dirname(__FILE__) .'/../../index.php';
	
}