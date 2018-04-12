<?php
defined('PHP168_PATH') or die();

$this_controller->check_action('view') or message($P8LANG['no_privilege']);

if(REQUEST_METHOD == 'GET'){

}elseif(REQUEST_METHOD == 'POST'){
	$id = intval($_POST['id']);
	$act = $_POST['act'];
	if($act=='com'){
		$data = array();
		$data['uid'] = $UID;
		$data['name'] = $USERNAME;
		$data['timestamp'] = time();
		$data['content'] = html_entities(from_utf8(($_POST['content'])));
		$ret = $this_module->comment($data);
	}elseif($act=='up'){
		$ups = get_cookie('opinion_up');
		if($ups){
			$ups = explode(',',$ups);
			if(in_array($id,$ups)){
				exit('{"error":1}');
			}
		}
		$ups[]=$id;
		set_cookie('opinion_up',implode(',',$ups),864000);
		$this_module->updown($id,1);
		$ret = array('error'=>0);
	}elseif($act=='down'){
		$dows = get_cookie('opinion_do');
		if($dows){
			$dows = explode(',',$dows);
			if(in_array($id,$dows)){
				exit('{"error":1}');
			}
		}
		$dows[]=$id;
		set_cookie('opinion_do',implode(',',$dows),864000);
		$this_module->updown($id,2);
		$ret = array('error'=>0);
	}
	echo p8_json($ret);
	exit;
}

