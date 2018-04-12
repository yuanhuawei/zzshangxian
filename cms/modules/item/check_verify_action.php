<?php
defined('PHP168_PATH') or die();

//检查当前分类权限
$cid = isset($_GET['cid'])? intval($_GET['cid']) : '';
if($cid && $this_controller->check_category_action('verify', $cid)){
	exit('var is_verify = true;');
}
exit('var is_verify = false;');