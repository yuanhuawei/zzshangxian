<?php
defined('PHP168_PATH') or die();

//��鵱ǰ����Ȩ��
$cid = isset($_GET['cid'])? intval($_GET['cid']) : '';
if($cid && $this_controller->check_category_action('verify', $cid)){
	exit('var is_verify = true;');
}
exit('var is_verify = false;');