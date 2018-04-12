<?php
defined('PHP168_PATH') or die();
if(!$this_controller->check_action($ACTION)){
	if(P8_AJAX_REQUEST)exit(p8_json('no_privilege'));
	message('no_privilege');
}

if(REQUEST_METHOD=='POST'){
	
	check_spam() && (P8_AJAX_REQUEST ? exit('{}') : message('dont_spam'));
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	$_POST['verify'] =($this_controller->check_action('autoverify'))? 1 : 0;
	if(P8_AJAX_REQUEST){
		$_POST = from_utf8($_POST);
	}
	
	$id = $this_controller->add($_POST) or message('fail');
	if(P8_AJAX_REQUEST){
		if($id){
			$query = $this_module->get($id);
			$query['timestamp']=date('Y-m-d H:i:s',$query['posttime']);
			$query['ip'] = preg_replace("/(\d+\.\d+\.)\d+(\.\d+)/","\\1*\\2",$query['ip']);
				exit(p8_json($query));
		}
		exit('{}');
	
	}
	message(
		array(
			array($P8LANG['guestbook']['gotoview'], $this_router.'-view-id-'.$id),
			array($P8LANG['guestbook']['gotolist'], $this_router),
			array($P8LANG['guestbook']['gotoindex'], $core->url)
		),
		$this_router.'-view-id-'.$id,
		10000
	);
	
}
include template($this_module, 'main');
?>