<?php
defined('PHP168_PATH') or die();

$odata = $this_module->data(intval($_POST['id']));
	if(!$odata)die();
	if(!$this_controller->check_category_action('edit',$odata['cid'])){
		if($UID != $odata['uid'] || $odata['status'] !=1 || $odata['closed'] !=0 || $odata['endtime'] < P8_TIME)exit("no_category_privilege");
	}
$id = $this_controller->post_edit($_POST) or message('ask_error', $this_system->controller, 3);

$url = p8_url($this_module, $_POST, 'view');

message('ask_success_update_item', $url, 3);