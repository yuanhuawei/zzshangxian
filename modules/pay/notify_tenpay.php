<?php
if(defined('PHP168_PATH')){
	
	if(REQUEST_METHOD == 'POST'){
		
		echo '<meta name="TENCENT_ONLINE_PAYMENT" content="China TENCENT">';
		
		//传回来的订单编号
		$NO = isset($_POST['mch_vno']) ? $this_controller->valid_NO($_POST['mch_vno']) : '';
		$NO or exit('fail');
		
		if($this_module->notify('tenpay', $NO) !== null){
			//验证成功
			write_file(CACHE_PATH .'log/notify_tenpay.php', '<?php exit;?>'. var_export($_POST, true), 'a');
			exit;
		}
	}
	
}else{
	
	$_REQUEST['_no_session'] = 1;
	$_SERVER['_REQUEST_URI'] = '/index.php/pay-notify_tenpay';
	require dirname(__FILE__) .'/../../index.php';
}