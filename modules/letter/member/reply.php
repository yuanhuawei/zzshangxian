<?php
defined('PHP168_PATH') or die();
$this_controller->check_action('manager') or message('no_privilege');
GetGP(array('id','act'));
if(!$id)
	message('error');
$data = $this_module->getData($id,'all');

$this_controller->check_acl('manager',$data['department']) or	message('no_privilege');

if(REQUEST_METHOD=='GET'){
//print_r($data);
	!empty($data['attachment']) && $data['attachment']= attachment_url($data['attachment']);
	$cates = $this_module->get_category();
	$id_type = $this_module->id_type();
	$ptitle = $P8LANG['reply'];	
	
	$shortcutsms = $core->load_module('shortcutsms');
	$shortcuts = $shortcutsms->getAll();
	$mana_message = $this_controller->manageMessage();
	include template($this_module, "reply");
}else if(REQUEST_METHOD=='POST'){

	$this_controller->reply($_POST);
message(	array(
				array('to_list', $this_router .'-manage'),
				array('to_update', $this_url .'?id='.$_POST['id']),
			),
			$this_router .'-manage',
			3000
		);

}

?>