<?php
defined('PHP168_PATH') or die();

/**
* 修改内容入口文件
**/

//$this_controller->check_action($ACTION) or message('no_privilege');
$id = isset($_REQUEST['id'])? intval($_REQUEST['id']) : '';
$id or message('no_such_item');
if(isset($id)){
	$data = $this_module->get_data($id);
	$data or message('no_such_item');
	$mid = $data['mid'];
	if(!$this_controller->check_model_action('manage',$mid)){
		if($data['uid'] != $UID ){
			message('no_model_privilege');
		}elseif($data['uid'] == $UID && $data['status']>0){
			//message($P8LANG['forms_is_status']);
		}
		
	}	
	$this_module->set_model($mid) or message('no_such_model');
	
}

if(REQUEST_METHOD == 'GET'){
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $this_model['alias'];	
	
	$data = $this_module->get_data($id,$this_model['name']);
	$data or message('no_such_item');
	$this_module->format_data($data);
	$attachment_hash = unique_id(16);
	include template($this_module, 'edit');

}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	//修改也要重新处理
	$_POST['status'] = $this_controller->check_model_action('authmanage',$mid)? 9 : 0;
	
	
	$status = $this_controller->update($id, $_POST) or message('fail');
	
	if($_POST['status']<1){
		message('verifing');
	}else{
		message(
			array(
				array('forms_to_edit', $this_module->controller .'-update?id='.$id.'&mid='.$mid),
				array('forms_to_list', $this_module->controller .'-list-mid-'.$mid),
				array('forms_to_view', $this_module->controller .'-view-id-'.$id)
			),
			$this_module->U_controller .'-add?cid='.$_POST['cid'].'&model='.$_POST['model'],
			10000
		);
	}
	
}