<?php
defined('PHP168_PATH') or die();
$this_controller->check_action('manager') or message('no_privilege');
GetGP(array('id','act'));
if(!$id)
	message('error');
$data = $this_module->getData($id,'all');

$this_controller->check_acl('manager',$data['department']) or	message('no_privilege');
$display = $this_controller->check_action('display');
$editletter = $this_controller->check_acl('edit',$data['department']);

if(REQUEST_METHOD=='GET'){
//print_r($data);
	!empty($data['attachment']) && $data['attachment']= attachment_url($data['attachment']);
	$cates = $this_module->get_category();
	$id_type = $this_module->id_type();
	$ptitle = $P8LANG['reply'];	
	
	$departments = $this_controller->getcatbyAct('turnover');
	
	
	$delletter = $this_controller->check_acl('delletter',$data['department']);
	$turnover = $this_controller->check_acl('turnover',$data['department']);
	$vefify = $this_controller->check_acl('vefify',$data['department']);
	$endtime = $this_controller->check_acl('endtime',$data['department']);
	$display = $this_controller->check_acl('display',$data['department']);

	$shortcutsms = $core->load_module('shortcutsms');
	$shortcuts = $shortcutsms->getAll();
	$mana_message = $this_controller->manageMessage();
	$TITLE = $TITLE = $data['title'] .'_'. $core->CONFIG['site_name'];	
	include template($this_module, "reply");
}else if(REQUEST_METHOD=='POST'){

	if(!$display)unset($_POST['undisplay']);
	if(!$editletter)unset($_POST['reply']);
	
	$this_controller->reply($_POST);
message(	array(
				array('to_list', $this_router .'/../opinion-letter'),
				array('to_update', $this_url .'?id='.$_POST['id']),
				array('to_view', $this_router .'-view-id-'.$_POST['id']),
			),
			$this_router .'/../opinion-letter',
			3000
		);

}

?>