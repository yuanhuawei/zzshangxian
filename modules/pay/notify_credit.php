<?php
defined('PHP168_PATH') or die();

//if(REQUEST_METHOD == 'POST'){
//���֧��,����ύ����һ��,˵���û��Ѿ�ȷ��֧��
$NO = isset($_POST['order_NO']) ? $this_controller->valid_NO($_POST['order_NO']) : '';

if($this_module->notify('credit', $NO) !== null){
	//��֤�ɹ�
	/*write_file(CACHE_PATH .'log/credit_notify.php', '<?php exit;?>'. var_export($_POST, true), 'a');*/
	exit('success');
}
//}
exit('fail');