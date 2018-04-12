<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD=="GET"){
	
	
	$LABEL = &$core->load_module('label');
	load_language($core, 'config');
	load_language($LABEL, 'global');
	load_language($this_system, 'admin');
	load_language($this_module, 'label');
	load_language($this_module, 'label');
	
	$action=isset($_GET['action'])?$_GET['action']:'';
	$id = isset($_GET['id']) ? $_GET['id'] : '';
	$data=array();
	
	//?????????
	$data['id'] = $id = isset($_GET['id']) ? $_GET['id'] : '';
	$name = isset($_GET['name']) ? $_GET['name'] : '';
	
	if(!empty($id) && !empty($name)){
		$data['name']=$name;
		$action="update";
	}

	$option=array();
	switch($action){
		case 'update':
			$data = $LABEL->view($id);
			$option = $data['option'];
			if(!empty($option['tplcode']))$option['tplcode']=stripcslashes($option['tplcode']);
		break;
	}
	
	include template($this_module, 'label', 'admin');
	
}else{

	$action=isset($_GET['action'])?$_GET['action']:'';

	switch($action){
		case 'list':
				
			header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
			header("Cache-Control: no-cache, must-revalidate" );
			header("Pragma: no-cache");
			header("Content-type: text/x-json");
				
			$ps = isset($_POST['ps']) ? $_POST['ps'] < 0 ? 2 : $_POST['ps'] > 10 ? 10 : $_POST['ps'] : 10;
			$cp = isset($_POST['cp']) ? $_POST['cp'] > 0 ? $_POST['cp'] : 1 : 1;
			$start = ($cp-1) * $ps;
			$count = 0;

			$json_data = array();
			$rs = $DB_master->query("SELECT COUNT(*) cou FROM $this_module->table_subject");
			if($row=mysql_fetch_array($rs,MYSQL_ASSOC)){
				$count=$row['cou'];
			}

			$json_data['count'] = $count > 0 ? (int)(($count-1)/$ps)+1 : 0;

			if($json_data['count'] > 0 && $json_data['count'] >= $cp){

				$rs = $DB_master->query("SELECT * FROM $this_module->table_subject ORDER BY begintime DESC LIMIT $start,$ps");

				$i=0;
				while($row=mysql_fetch_array($rs,MYSQL_ASSOC)){
					$json_data[$i++] = array("id"=>$row['id'],"title"=>$row['title'],"gname"=>$row['gname'],"begintime"=>$row['begintime']);
				}

				$json_data['total']=$i;
			}else{
				$json_data['total'] = 0;
			}
			$json_data['cp'] = $cp;
			echo jsonencode($json_data);
			break;

		case 'update':

			require $this_module->path .'admin/valid_data.php';
			$_POST['option'] = $option;
			$controller->update($_POST['id'],$_POST) or message('fail');
			message('done');
		break;

		case 'add':

			require $this_module->path .'admin/valid_data.php';
			$_POST['option'] = $option;
			$controller->add($_POST) or message('fail');
			message('done');
		break;
		case 'preview':
			require $this_module->path .'admin/preview.php';
		break;
		default:
		echo 'error';
	}
	exit;
}