<?php
defined('PHP168_PATH') or die();

/**
* �����ύ
**/
if($REQUEST_METHOD == 'GET'){

}else if(REQUEST_METHOD == 'POST'){
	$status = $this_controller->add_order($_POST);
	$ret = json_encode($status);
	exit($ret);
}