<?php
defined('PHP168_PATH') or die();

/**
* ¶ÀÁ¢±íµ¥
**/

if(REQUEST_METHOD == 'GET'){
	$manage = $this_controller->check_action('manage');
	$my_manage_forms = $this_controller->get_acl('my_forms_manage');
	$my_post_forms = $this_controller->get_acl('my_forms_post');
	$manage_forms = $post_forms = array();
	$models = $this_module->core->CACHE->read('core/modules', 'forms', 'models');
	foreach($models as $mname => $mdata){
		$manage_forms[$mname] = $post_forms[$mname] = array('id'=>$mdata['id'], 'alias'=>$mdata['alias']);
	}
	if(!$IS_FOUNDER){
		foreach($models as $mname => $mdata){
			if(!array_key_exists($mdata['id'],$my_manage_forms) && !isset($my_manage_forms[0])) unset($manage_forms[$mname]);
			if(!array_key_exists($mdata['id'],$my_post_forms) && !isset($my_post_forms[0]))unset($post_forms[$mname]);
		}
	}
	$mid = isset($_GET['mid'])? intval($_GET['mid']) : 'null';
	$action = isset($_GET['ac'])? $_GET['ac'] : 'myforms';
	$selectstatus = isset($_GET['se'])? intval($_GET['se']) : '';
	$status = $this_module->CONFIG['status'];
	//$statuses = $this_module->get_statuses();
	$status_json = p8_json($status);
	$navgation = array(array('url'=>$this_url,'title'=>$P8LANG['intraneteforms']));
	$baner = 'intraneteforms';
	$TITLE =$P8LANG['forms'];
	
	$manage_forms_json = p8_json($manage_forms);
	$post_forms_json = p8_json($post_forms);
include template($this_module, 'intranetforms');

}elseif(REQUEST_METHOD == 'POST'){


}