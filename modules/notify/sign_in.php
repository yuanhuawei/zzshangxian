<?php
defined('PHP168_PATH') or die();

/**
* Ç©µ½
**/

if(REQUEST_METHOD == 'GET'){
	
	$data = $this_controller->valid_sign_in($_GET);
	if(!$data['id'] || !$data['uid'] || !$data['hash']) message('access_denied');
	
	$signin = $DB_master->fetch_one("SELECT s.*, n.title FROM $this_module->sign_in_table AS s INNER JOIN $this_module->table AS n ON n.id = s.nid WHERE s.nid = '$data[id]' AND s.uid = '$data[uid]'");
	if(empty($signin) || $signin['uid'] != $data['uid'] || $signin['hash'] != $data['hash']){
		message('access_denied');
	}
	
	if($signin['status']){
		message($P8LANG['notify_sign_in_already'] .'<script type="text/javascript">alert("'. $P8LANG['notify_sign_in_already'] .'"); setTimeout(function(){ window.close(); }, 5000);</script>');
	}
	
	include template($this_module, 'sign_in', 'default');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$data = $this_controller->valid_sign_in($_POST);
	if(!$data['id'] || !$data['uid'] || !$data['hash']) message('access_denied');
	
	$this_module->sign_in($_POST) or message('access_denied');
	
	message($P8LANG['done'] .'<script type="text/javascript">alert("'. $P8LANG['done'] .'"); setTimeout(function(){ window.close(); }, 5000);</script>');
	
}