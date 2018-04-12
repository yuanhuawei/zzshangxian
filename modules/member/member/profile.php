<?php
defined('PHP168_PATH') or die();

$this_model = $this_module->get_model($ROLE_GROUP);
$this_module->set_model($ROLE_GROUP);

if(REQUEST_METHOD == 'GET'){
	
	error_reporting(0);
	$select = select();
	$select->from($this_module->table .' AS m', 'm.*');
	$select->inner_join($this_module->addon_table .' AS f', 'f.*', 'm.id = f.id');
	$select->in('m.id', $UID);
	$data = $core->select($select, array('single' => true));
	if(empty($data)){
		//自定义字段表如果不存在就新增数据
		$DB_master->insert($this_module->addon_table, array('id' => $UID));
		header('Location: '. $this_url);
		exit;
	}
	
	$this_module->format_data($data);
	$data['icon']=attachment_url($data['icon']);
	if($data['birthday']){
		$by[date("Y",$data['birthday'])] = " selected" ;
		$bm[date("m",$data['birthday'])] = " selected" ;
		$ba[date("d",$data['birthday'])] = " selected" ;
}
	if($data['gender']=='2'){
		$data['2']=" checked ";
	}elseif($data['gender']=='1'){
		$data[1]=" checked ";
	}else{
		$data[0]=" checked ";
	}
	
	include template($this_module, 'profile');
}else if(REQUEST_METHOD == 'POST'){
	
	$job=isset($_POST['job'])? $_POST['job'] : '';
	
	if($job=='passwd'){
		GetGP(array('old_password','new_password','confirm_password'));
		
		switch($s = $this_controller->change_password($USERNAME, $old_password, $new_password, $confirm_password)){
			case 0:
				message('done');
			break;
			
			case -1:
				message('password_not_match');
			break;
			
			case -2:
				message('input_old_password');
			break;
		}
		echo $s;
	}else{
		//不允许修改的字段
		unset($_POST['role_id'], $_POST['role_gid'], $_POST['is_founder'], $_POST['status']);
		
		$_POST['birthday'] = $_POST['birthday_year']."-".$_POST['birthday_month']."-".$_POST['birthday_day'];
		$_POST['usercenter'] = 1;
		$status = $this_controller->update($UID, $_POST);
		
		if(isset($status['error']))
			message($status['error']);
		
		message('done');
		
	}
}