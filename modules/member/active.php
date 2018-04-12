<?php
defined('PHP168_PATH') or die();
if(REQUEST_METHOD == 'GET'){

	$id = intval($_GET['id']);
	$salt = html_entities($_GET['salt']);
	if($id && $salt){
		$result=$DB_master->fetch_one("SELECT * FROM $this_module->table WHERE id='$id' AND salt='$salt'");
		if($result)	{
			$DB_master->update(
				$this_module->table,
				array(
				'status' => 0
				),
				" id='$id'"
			);
			$message = p8lang($P8LANG['register_active_success'],$this_module->core->url);
		}else{
			$message = p8lang($P8LANG['fail']);
		}
		include template($this_module, 'register_message', 'default');
	}else{
		message('fail');
	}
}