<?php
defined('PHP168_PATH') or die();

/**
* 添加模型内容入口文件
**/

$this_controller->check_action($ACTION) or message('no_privilege');
$mid = isset($_REQUEST['mid'])? intval($_REQUEST['mid']) : '';
if($mid){
	
	$this_controller->check_model_action($ACTION, $mid) or message('no_model_privilege');
	
	$this_module->set_model($mid) or message('no_such_model');
	if(!$this_model['enabled']){
		message('this_model_unable');
	}
}else{
	$my_addible_forms = $this_controller->get_acl('my_forms_post');
		$models = $this_module->core->CACHE->read('core/modules', 'forms', 'models');
		if(!isset($my_addible_forms[0]) && !$IS_FOUNDER){
			foreach($models as $mname => $mdata){
				if(!array_key_exists($mdata['id'],$my_addible_forms))
				unset($models[$mname]);
			}
		}
		$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
		$TITLE = 'chose';	
		include template($this_module, 'selectforms');
	
	exit;
}

if(REQUEST_METHOD == 'GET' || defined('P8_GENERATE_HTML')){
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $this_model['alias'];	
	//$this_module->CONFIG['template']='media';
	
	//模型自定义脚本
	include $this_model['path'] .'post.php';
	
	$template = empty($this_model['post_template']) ?
		'edit' :
		'tpl/'.$this_model['post_template'];
	$attachment_hash = unique_id(16);
	include template($this_module, $template);

}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	
	$_POST['status'] = $this_controller->check_model_action('authmanage',$mid)? 9 : 0;
	if($this_model['CONFIG']['captcha'] && !captcha($_POST['captcha']))message('captcha_incorrect', HTTP_REFERER, 10);
	//模型自定义脚本
	include $this_model['path'] .'post.php';
	
	$id = $this_controller->add($_POST) or message('fail');
	
	if($_POST['status']<1){
		message('verifing', $this_url.'?mid='.$mid);
	}else{
		message(
			array(
				array('forms_to_edit', $this_module->controller .'-update?id='.$id.'&mid='.$mid),
				array('forms_to_list', $this_module->controller .'-list-mid-'.$mid),
				array('forms_to_view', $this_module->controller .'-view-id-'.$id),
				array('forms_to_add', $this_url.'?mid='.$mid)
			),
			$this_module->controller .'-post?cid='.$_POST['cid'].'&mid='.$mid,
			10000
		);
	}	
}