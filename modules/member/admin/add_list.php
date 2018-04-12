<?php
defined('PHP168_PATH') or die();

/**
 * 批量导入会员资料
 **/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$role = &$core->load_module('role');
	$role->get_cache();

	include template($this_module, 'add_list', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	isset($_FILES['csv_file']) or message('error');
	
	if ($_FILES["csv_file"]["error"] > 0||"application/vnd.ms-excel"!=$_FILES["csv_file"]["type"]||($_FILES["csv_file"]["size"] / 1024)>10000){
		message('error');
	}
	/*
	require_once PHP168_PATH .'inc/csv.class.php';
	$csv = new P8_Csv($_FILE['csv_file']['tmp_name']);
	if(empty($csv->data)){
		message('access_denied');
	}
	
	//去掉第一行
	array_shift($csv->data);
	foreach($csv->data as $v){
		if(!isset($v[0]) || !isset($v[1])) continue;
		
		$this_controller->register($v[0], $v[1], $v[3]);
	}*/
	
	function check_file_content($content){
		$error = array();
		
		foreach($content as $row){
			$rows[] = preg_replace("/\"\"/", "'", $row);
		}
		
		$tmp=array();
		$result=array();
		
		for($i=0; $i < count($rows); $i++){
			
			$flag = preg_match_all("/\"([^\"]*)\"/", $rows[$i], $tmp[$i]);
			if(is_bool($flag) && $flag===false){
				$error = $row[$i];
				continue;
			}
			$result[$i]=explode(',', preg_replace("/\"([^\"]*)\"/", "#", $rows[$i]));
		}
		
		for($i=0; $i < count($result); $i++){
			
			for($j=0;$j<count($result[$i]);$j++){
				
				if($result[$i][$j] == '#'){
					$result[$i][$j] = $tmp[$i][$j];
				}
			}
		}
		return array($result,$error);
	}
	
	$content = file($_FILES["csv_file"]["tmp_name"]);
	$result = check_file_content($content);
	if(!empty($result[1])&&count($result[1])>0){
		include template($this_module, 'add_list', 'admin');
		exit;
	}
	
	$success=array();
	$fail=array();
	if(!empty($result[0])){
		for($i = 1; $i < count($result[0]); $i++){
			
			$data['username'] = isset($result[0][$i][0]) ? $result[0][$i][0]:'';
			$data['password'] = isset($result[0][$i][1]) ? $result[0][$i][1]:'';
			$data['email'] = isset($result[0][$i][4]) ? $result[0][$i][4]:'';
			
			if($this_controller->register($data)>0){
				
				$success[]=array(
				"username" => isset($result[0][$i][0]) ? $result[0][$i][0] : '',
				"name" => isset($result[0][$i][2]) ? $result[0][$i][2] : '',
				"gender" => isset($result[0][$i][3]) ? ($result[0][$i][3] == '女' ? 2 : 1) : 0,
				"phone" => isset($result[0][$i][5]) ? $result[0][$i][5] : '',
				"fax" => isset($result[0][$i][6]) ? $result[0][$i][6] : '',
				"cell_phone" => isset($result[0][$i][7]) ? $result[0][$i][7] : '',
				"address" => isset($result[0][$i][8]) ? $result[0][$i][8] : '',
				"memo" => isset($result[0][$i][9]) ? $result[0][$i][9] : ''
				);
			}else{
				$fail[] = $result[0][$i][0];
			}
		}
	}
	if(!empty($success)){
		
		foreach($success as $user){
			if($user['name']==''||!preg_match("/^\\d+-\\d+$/",$user['phone'])){
				
				$flag = $DB_master->query("DELETE FROM $this_module->table WHERE username='".$user['username']."'");
				if($flag){
					$fail[]=$user['username'];
				}
			}else{
				$flag=$DB_master->query("UPDATE $this_module->table SET name='".$user['name']."',gender=".$user['gender'].",phone='".$user['phone']."',fax='".$user['fax']."',cell_phone='".$user['cell_phone']."',address='".$user['address']."',memo='".$user['memo']."' WHERE username='".$user['username']."'");
				if(!$flag){
					$flag=$DB_master->query("DELETE FROM $this_module->table WHERE username='".$user['username']."'");
					if($flag){
						$fail[]=$user['username'];
					}
				}
			}
		}
	}
	if(empty($fail)){
		message('数据导入成功',$this_url);
	}else{
		$fail_users='<br>';
		foreach($fail as $user){
			$fail_users.=$user.'<br>';
		}
		message('以下用户导入失败,可能原因为用户已存在或字段格式不正确：'.$fail_users);
	}
}