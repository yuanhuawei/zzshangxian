<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$data['type'] = 'module_data';

if(REQUEST_METHOD == 'GET'){
	
	$LABEL = &$core->load_module('label');
	load_language($core, 'config');
	load_language($LABEL, 'global');
	load_language($this_system, 'admin');
	load_language($this_module, 'label');
	
	$action = isset($_GET['action']) ? $_GET['action']:'';
	$id = isset($_GET['id']) ? $_GET['id'] : '';
	$data=array();
	
	//为了重设标签
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
			if(!empty($option['tplcode'])) $option['tplcode'] = stripcslashes($option['tplcode']);
		break;
	}
	include template($this_module, 'label', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){

	$action=isset($_GET['action'])?$_GET['action']:'';

	switch($action){
		case 'linklist':
			define('NO_ADMIN_LOG', true);
			
			$ps = isset($_POST['ps']) ? $_POST['ps'] < 0 ? 2 : $_POST['ps'] > 10 ? 10 : $_POST['ps'] : 10;
			$cp = isset($_POST['cp']) ? $_POST['cp'] > 0 ? $_POST['cp'] : 1 : 1;
			$start = ($cp-1) * $ps;
			$count = 0;

			$json_data = array();
			$rs = $DB_master->fetch_one("SELECT COUNT(*) AS `count` FROM $this_module->table_sort");
			$count = $rs['count'];

			$json_data['count'] = $count > 0 ? (int)(($count-1)/$ps)+1 : 0;

			if($json_data['count'] > 0 && $json_data['count'] >= $cp){

				$rs = $DB_master->query("SELECT * FROM $this_module->table_sort LIMIT $start,$ps");

				$i=0;
				while($row = $DB_master->fetch_array($rs)){
					$json_data[$i++] = array("fid"=>$row['fid'],"name"=>$row['name']);
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
			message(
				array(
					array('gotoview', str_replace('edit_label=1','',$HTTP_REFERER)),
					array('gotoedit', $this_router.'-label?action=update&id='. $_POST['id']),
					array('gotolabel', $HTTP_REFERER)
				)
			);
		break;

		case 'add':

			require $this_module->path .'admin/valid_data.php';
			$_POST['option'] = $option;
			$controller->add($_POST) or message('fail');
			message(
				array(
					array('gotoview', str_replace('edit_label=1','',$HTTP_REFERER)),
					array('gotoedit',$this_router.'-label?action=update&id='.$_POST['id'])
				)
			);
		break;
		case 'preview':
			$_POST = from_utf8($_POST);
	
			require $this_module->path .'admin/valid_data.php';
			
			$controller = &$core->controller($LABEL);
			$label = $controller->valid_data($_POST);
			
			require $LABEL->path .'inc/preview.php';
		break;
		case 'explain':
			require $this_module->path .'admin/valid_data.php';
			$_POST['option'] = $option;
			require $LABEL->path .'inc/explain.php';
		break;
		default:
		echo 'error';
	}
	exit;
}