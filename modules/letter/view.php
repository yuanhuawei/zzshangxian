<?php
defined('PHP168_PATH') or die();

/**
* 查看内容入口文件
**/

$this_controller->check_action($ACTION) or message('no_privilege');
$id = 0;
$id = isset($_GET['id'])? intval($_GET['id']): 0;
foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'id':
			$id = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			$PAGE_CACHE_PARAM['id'] = $id;
			break 2;
		break;
	}
}
$id or message('no_such_item');
if(REQUEST_METHOD == 'GET'){
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';

	if(!$id)
		message('error');

	$data = $this_module->getData($id,'all');
	$data or message('no_such_item');
	
	if(isset($_GET['act']) && $_GET['act']=='del'){
		$this_controller->check_action('manager') or message('no_privilege');
		$this_module->delete(array('ids'=>array($id)));
		message('done',$this_router.'-list');
	}
	
	if($data['visual']==0 && $data['uid']!==$UID){
		$this_controller->check_acl('manager',$data['department']) or	message('no_privilege');
	}
	$TITLE = $TITLE = $data['title'] .'_'. $core->CONFIG['site_name'];	
	foreach($data['data'] as $key=>$addon){
		if(!empty($addon['attachment'])){
			$data['data'][$key]['attachment']= attachment_url($addon['attachment']);
		}	
	}
	$isposter = $UID && $data['uid']==$UID;
	$manager = $this_controller->check_acl('manager',$data['department']);
	$delletter = $this_controller->check_acl('delletter',$data['department']);
	//print_r($data);
	if(!$manager && !$isposter){
		$data['username'] = setSecret($data['username'],'name');
		$data['id_num'] = setSecret($data['id_num'],'tel');
		$data['email'] = setSecret($data['email'],'email');
		$data['address'] = setSecret($data['address'],'address');
		$data['phone'] = setSecret($data['phone'],'tel');
	}
	$id_type = $this_module->id_type();
	$cates = $this_module->get_category();
	$comments = $this_module->get_comments();
	
	//初始化标签
	$LABEL_POSTFIX = array();
	//如果分类有自己的标签后缀
	array_push($LABEL_POSTFIX, 'gb_cid_'.intval($data['department']));	
	
	include template($this_module, 'view');
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$id or message('no_such_item');
	$data = $this_module->getData($id);
	if($data['uid']!=$UID && !$IS_FOUNDER){
		message('no_privilege');
	}
	$common = intval($_POST['common']) or message('error');
	
	$this_module->comment($id,$common);
	
	message('common_success',$this_url.'-id-'.$id,5);
	
}