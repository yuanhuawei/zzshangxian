<?php
defined('PHP168_PATH') or die();
$id= intval($_GET['id']);
$data = $this_module->getData($id);
if($data['uid']!=$UID)message('no_privilege');	
$param = array('ids'=>array($id));
$this_module->delete($param);

message(
	array(
				array('to_list', $this_router .'-list'),
				array('colsed', "javascript:window.close();"),
			),
			$this_router .'-list',
			3000
		);

?>