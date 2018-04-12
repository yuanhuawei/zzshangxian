<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$id = 0;
	foreach($URL_PARAMS as $k => $v){ 
		switch($v){
			case 'id':
				$id = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			break;
		}
	}
	$id = $id? intval($id): intval($_GET['id']);
	if(!$id)message('not_such_item');
	
	$data = $this_module->get_item($id);
	$this_module->update_view($id);
	//if(!empty($data['endtime']) && $data['endtime']<P8_TIME)message('had_end',$this_router.'-view-id-'.$id);
	$manager = $this_controller->check_action('manage');
	$titles = $this_module->get_titles($id);

	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $data['title'];	
	
	$template = empty($data['post_template']) ?	'post' : $data['post_template'];
	include template($this_module, $template);
//echo ' <pre>';	
//print_r($data);	
//print_r($titles);	
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);

	$iid = intval($_POST['iid']);
	if(!$iid)message($P8LANG['not_such_item']);
	
	if(get_cookie('survey_post_'.$iid)){
		message($P8LANG['had_post']);
	}
	
	$data = $this_module->get_item($iid);
	
	if($data['captcha'] && !captcha($_POST['captcha'])){
		message($P8LANG['captcha_incorrect']);
	}
	
	
	$id = $this_controller->add_data($_POST) or message('fail');
	
	$ss = set_cookie('survey_post_'.$iid,time(),86400);
	message('survey_success', $this_router.'-view-id-'.$iid);
	
}