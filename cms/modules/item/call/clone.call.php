<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::move($id, $cid, $verified = true){
	$ids = implode(',', (array)$id);
	
	if(!strlen($ids)){
		return false;
	}
	
	if($verified){
		$T = $this->main_table;
		$fields = 'url, html_view_url_rule, pages, timestamp';
	}else{
		$T = $this->unverified_table;
		$fields = '';
	}
	
	$cat = $this->system->fetch_category($cid);
	if(empty($cat)) return false;
	
    $_cats = array();
    
	require_once PHP168_PATH .'inc/html.func.php';
	
	
	$query = $this->DB_slave->query("SELECT * FROM $this->main_table WHERE id IN ($ids)");
	$controller = &$this->core->controller($this);
	
	$data = array();
	$i = 0;
	$newids= array();
	while($arr = $this->DB_slave->fetch_array($query)){
        
		$model = $this->system->get_model($cat['model']);
		$_REQUEST['model'] = $cat['model'];
		$this->system->init_model();
		$this->set_model($cat['model']);


        $data[$i] = $arr;
        if(!isset($_cats[$arr['cid']])) $_cats[$arr['cid']] = $this->system->fetch_category($arr['cid']);
        $arr['#category'] = $_cats[$arr['cid']];
        $data[$i]['url'] = p8_url($this, $arr, 'view');
        $data[$i]['model'] = $cat['model'];
        
        if(isset($data[$i]['source'])){
            $tmp = explode('|', $data['source']);
            $data[$i]['source_name'] = $tmp[0];
            $data[$i]['source_url'] = isset($tmp[1]) ? $tmp[1] : '';
        }
        $data[$i]['summary'] = preg_replace('/(amp;)+/','', $data[$i]['summary']);
        unset($data[$i]['label_postfix']);
        
        
        $data[$i]['client_item_id'] = $arr['id'];
		$data[$i]['cid'] = $cid;
		
		$data[$i]['frame'] = attachment_url($data[$i]['frame']);
		$data[$i]['comments'] = 0;
		$data[$i]['views'] = 0;
		$data[$i]['html'] = 0;
		$data[$i]['vid'] = 0;
		$data[$i]['attributes'] = '';
		$data[$i]['action'] = 'add';
		$data[$i]['timestamp'] = $clone_time?$clone_time:date('Y-m-d H:i:s',$arr['timestamp']);

        $data[$i]['verify'] = $arr['verified'];
		$data[$i]['verifier'] = $arr['verifier'];
		unset($data[$i]['id'],$data[$i]['iid'],$data[$i]['list_order']);
		if($newid = $controller->add($data[$i])){
			$newids[] = $newid;
		}
		$i++;
	}
	
	
    return true;