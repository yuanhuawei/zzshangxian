<?php
defined('PHP168_PATH') or die();

$action = isset($_POST['action']) ? $_POST['action'] : '';
$ids = isset($_POST['ids']) ? $_POST['ids'] : '';

switch($action){
	//通过审核
	case 'pass_verify':
		$json = $this_controller->pass_verify($ids);
		break;
	//取消审核
	case 'cancel_verify':
		$json = $this_controller->cancel_verify($ids);
		break;
	//删除分类专家
	case 'delete_expertor':
		$json = $this_controller->delete_expertor($ids);
		break;
	//设为问答之星
	case 'set_star':
		$json = $this_controller->set_star($ids);
		break;
	//取消问答之星
	case 'cancel_star':
		$json = $this_controller->cancel_star($ids);
		break;
}

if($action){
	echo jsonencode($json);
}

?>