<?php
defined('PHP168_PATH') or die();

/**
* 会员导入
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	include template($this_module, 'import', 'admin');
}else if(REQUEST_METHOD == 'POST'){

	isset($_FILES['import_file']) or message('error1');
	if ($_FILES["import_file"]["error"] > 0||($_FILES["import_file"]["size"] / 1024)>10000){
		message('error2');
	}
	set_time_limit(0);
	require_once PHP168_PATH.'inc/csv.class.php';
	$csv  = new P8_Csv();
	$csv->open($_FILES["import_file"]["tmp_name"]);
	if(!$csv->data)return;
	
	$rfield = array('id', 'username','password','email','role_id','role_gid','name','phone','cell_phone','address','qq','msn','fax');
	if(in_array($csv->data[1][0],$rfield)){
		unset($csv->data[0]);
		$fields = array_shift($csv->data);
	}else if(in_array($csv->data[0][0],$rfield)){
		$fields = array_shift($csv->data);
	}else{
		message('error3');
	}
foreach($csv->data as $m){
	$member = array_combine($fields,$m);
	if($member['username']){
		$s = $this_controller->check_username($member['username']);
		if($s == -1){
			record('the username <font color="red">'.$member['username'].'</font> is illegal. the import data is"'.implode(",",$m).'"');
			continue;
		}
		if($s == -2){
			record('the username <font color="red">'.$member['username'].'</font> is repeat. the import data is"'.implode(",",$m).'"');
			continue;
		}
	}else{
		continue;
	}
	if($member['email']){
		$ss = $this_controller->check_email($member['email']);
		if($ss == -1){
			record('the email <font color="red">'.$member['email'].'</font> is illegal. the import data is"'.implode(",",$m).'"');
			continue;
		}
		if($ss == -2){
			record('the email <font color="red">'.$member['email'].'</font> is repeat. the import data is"'.implode(",",$m).'"');
			continue;
		}
	}else{
		continue;
	}
	$data = $this_controller->valid_data($member);
	$id = $this_controller->register($member);
	if($id){
		unset($data['attachment_hash'],$data['#data#'],$data['password'],$data['email']);
		$status = $this_module->DB_master->update(
			$this_module->table,
			$data,
			"id = '$id'"
		);
		if(!$status){
			record('the email <font color="red">'.$member['username'].'</font> is inpurt error. the import data is"'.implode(",",$m).'"');
			$DB_master->query("DELETE FROM $this_module->table WHERE username='".$member['username']."'");
		}
	}else{
		record('the email <font color="red">'.$member['username'].'</font> is inpurt error. the import data is"'.implode(",",$m).'"');
		$DB_master->query("DELETE FROM $this_module->table WHERE username='".$member['username']."'");
	}
}
message(
	array(
		array('view', $this_router.'-list'),
		array('continue_add', $this_url)
	),
	$this_url,
	10000
);
}
function record($content){

	$recordfield = CACHE_PATH."import_member.html";
	
	$data = '['.date('Y-m-d h:i:s').']'."\t".$content.'<br>';
	write_file($recordfield,$data,'a');
}



