<?php
defined('PHP168_PATH') or die();

$action = isset($_POST['action']) ? $_POST['action'] : '';
$ids = isset($_POST['ids']) ? $_POST['ids'] : '';

switch($action){
	//ͨ�����
	case 'pass_verify':
		$json = $this_controller->pass_verify($ids);
		break;
	//ȡ�����
	case 'cancel_verify':
		$json = $this_controller->cancel_verify($ids);
		break;
	//ɾ������ר��
	case 'delete_expertor':
		$json = $this_controller->delete_expertor($ids);
		break;
	//��Ϊ�ʴ�֮��
	case 'set_star':
		$json = $this_controller->set_star($ids);
		break;
	//ȡ���ʴ�֮��
	case 'cancel_star':
		$json = $this_controller->cancel_star($ids);
		break;
}

if($action){
	echo jsonencode($json);
}

?>