<?php
defined('PHP168_PATH') or die();

/**
* 查看内容入口文件
**/
$id = isset($_GET['id'])? intval($_GET['id']):0;
$this_controller->check_action('view') or message('no_privilege');


if(REQUEST_METHOD == 'POST' || $id){
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$isposter = false;
	if($id){
		$data = $this_module->getData($id,'all');
		$isposter = $UID && $data['uid']==$UID;
		if(!empty($_POST['common']) && $data['uid']==$UID){
			$common = intval($_POST['common']) or message('error');
		
			$this_module->comment($id,$common);
		
		message('common_success',$this_url.'?id='.$id,5);
		}
	}else{
		$snumber 	= $_POST['snumber'];
		$susername = $_POST['susername'];
		
		$press = $this_module->getProgress(p8_html_filter($susername), p8_html_filter($snumber));
		if(!$press){
			message('no data',$this_router .'-detail',3);
		}
		$id = $press['id'];
		$isposter = true;
	}
	if(empty($data))$data = $this_module->getData($id,'all');	
	$manager = $this_controller->check_acl('manager',$data['department']);
	
	if(!$isposter && !$manager)message('no_privilege');
	
	$TITLE = $TITLE = $data['title'] .'_'. $core->CONFIG['site_name'];	
	foreach($data['data'] as $key=>$addon){
		if(!empty($addon['attachment'])){
			$data['data'][$key]['attachment']= attachment_url($addon['attachment']);
		}	
	}
	$isposter = true;
	//print_r($data);
	$id_type = $this_module->id_type();
	$cates = $this_module->get_category();
	$comments = $this_module->get_comments();
	
	if($data['uid'])
		$list = $this_module->getList(array('uid'=>$data['uid']));
	else
		$list = $this_module->getList(array('username'=>$data['username']));
	
	
	$cates = $this_module->get_category();
	$id_type = $this_module->id_type();
	foreach($list as $key=>$row){
		$list[$key]['status_name'] = $P8LANG['status_'.$row['status']];
		$list[$key]['department_name'] = $cates['department'][$row['department']]['name'];
		$list[$key]['type_name'] = $cates['type'][$row['type']]['name'];
		$list[$key]['url'] = $this_router.'-view-id-'.$row['id'];
		$list[$key]['title_s'] = p8_cutstr($row['title'],20);
	}
	include template($this_module, 'detail');

}
elseif(REQUEST_METHOD == 'GET'){
$cates = $this_module->get_category();	
	$tatistics = $this_module->getstatistics2();
include template($this_module, 'progress');

}