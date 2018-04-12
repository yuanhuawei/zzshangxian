<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$id = $page = 0;
	foreach($URL_PARAMS as $k => $v){ 
		switch($v){
			case 'id':
				$id = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			break;
			case 'page':
				$page = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			break;
		}
	}
	$id = $id? intval($id): intval($_GET['id']);
	if(!$id)message('not_such_item');
	
	$this_module->update_view($id);
	
	$data = $this_module->get_item($id);

	$page = max(1, $page);

	$manager = $this_controller->check_action('manage');
	//$page_url = p8_url($this_module, $data, 'post', false);
	$page_url = $this_url.'-id-'.$id.'#-page-?page?#.html ';
	$count = 0;
	$select = select();
	$select -> from($this_module->data_table,'*');
	$select -> order('id DESC');
	$select -> in('iid',$id);
	if(!$manager)$select -> in('status','1');
	$dataList = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);

	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $page_url
	));
	
	$comments = array();
	
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $data['title'];	
	
	$template = empty($data['post_template']) ?	'post' : $data['post_template'];
	include template($this_module, $template);
	
}else if(REQUEST_METHOD == 'POST'){
	
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	
	$id = intval($_POST['iid']);
	if(!$id)message('not_such_item');
	$data = $this_module->get_item($id);
	
	if($data['captcha'] && !captcha($_POST['captcha'])){
		$result = array('error'=>$P8LANG['captcha_incorrect']);
		echo p8_json($result);exit;
	}
	
	
	if(!$id = $this_controller->add($_POST)){
		$result = array('error'=>$P8LANG['fail']);
		echo p8_json($result);exit;
	}
	$rdata = $this_module->get($id);
	$rdata['time'] = date('Y-m-d H:i:s',$rdata['timestamp']);
	$result = array('error'=>0,'data'=>$rdata);
	echo p8_json($result);
	exit;
	
}