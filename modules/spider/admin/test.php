<?php
defined('PHP168_PATH') or die();

/**
* 测试采集结果
**/

$this_controller->check_admin_action('rule') or message('no_privilege');

define('NO_ADMIN_LOG', true);

if(REQUEST_METHOD == 'POST'){
	
	@set_time_limit(0);
	
	$_POST = p8_stripslashes2($_POST);
	
	$test = $_POST['test'] ? $_POST['test'] : '';
	$rule = $this_module->format_rule($this_controller->valid_data($_POST));
	//print_r($rule);
	
	switch($test){
	
	/* 列表页 */
	case 'list':
		$data = array();
		for($i = $rule['data']['start']; $i <= $rule['data']['end']; $i++){
			$data = array_merge($data, $this_module->capture_list($rule, $i, true));
		}
		
		$pages = $data['items'];
		unset($data['items']);
		
		include template($this_module, 'item_view', 'admin');
	break;
	
	
	/* 内容页 */
	case 'item':
		$data = $_data = array('pages' => array());
		
		$url = '';
		if(!isset($_POST['test_url'])){
			$ret = $this_module->capture_list($rule, 0, true);
			
			foreach($ret['items'] as $url => $v){
				
				break;
			}
		}else{
			$url = $_POST['test_url'];
		}
		
		//$url = 'http://tech.163.com/mobile/10/1217/06/6O39UUVQ00112K8F.html';
		$data = $this_module->capture_item($rule, $url, 0, true, 0);
		isset($data['frame']) || $data['frame'] = $v['frame'];
		
		if(is_string($data['pages'])){
			//下一页模式
			$data['pages'] = array( $data['pages'] => array('title' => 'next') );
		}else{
			foreach($data['pages'] as $_url => $_title){
				$_data = $this_module->capture_item($rule, $_url, 1, true, 0);
				
				break;
			}
		}
		
		//print_r($data);
		$pages = $data['pages'];
		
		$data = array_merge($data, $_data);
		
		unset($data['pages']);
		
		include template($this_module, 'item_view', 'admin');
		
	break;
	
	}
}