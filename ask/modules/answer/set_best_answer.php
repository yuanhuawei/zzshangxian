<?php
defined('PHP168_PATH') or die();

	$item = $this_system->load_module('item');
	$odata = $item->data($_POST['tid']);
	if(!$odata)die();
	if(!$this_controller->check_category_action($ACTION,$odata['cid'])){
		if($odata['uid'] != $UID && ($odata['status'] == 3 || $odata['endtime'] >= P8_TIME || $odata['closed']))exit("['no_category_privilege']");
	}
	
P8_AJAX_REQUEST or die();

$json = $this_controller->set_best_answer($_POST) or die();
echo jsonencode($json);
exit;