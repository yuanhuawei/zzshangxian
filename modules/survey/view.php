<?php
defined('PHP168_PATH') or die();

/**
* 查看内容入口文件
**/

$this_controller->check_action($ACTION) or message('no_privilege');


if(REQUEST_METHOD == 'GET'){
	$id = 0;
	$id = isset($_GET['id'])? intval($_GET['id']): 0;
	foreach($URL_PARAMS as $k => $v){
		switch($v){
			case 'id':
				$id = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			break;
		}
	}

	$id or message('no_such_item');

	
	$data = $this_module->get_item($id);
	$titles = $this_module->get_titles($id);
	$result = $this_module->getResult($id);
	$this_module->update_view($id);
	
	$data or message('no_such_item');
	
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $data['title'];	
	
	$template = empty($data['view_template']) ?	'view' : $data['view_template'];
	include template($this_module, $template);
//echo ' <pre>';	
//print_r($data);	
//print_r($titles);	
//print_r($result);
}else if(REQUEST_METHOD == 'POST'){
	
	
}