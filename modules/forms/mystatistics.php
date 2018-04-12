<?php
defined('PHP168_PATH') or die();

/**
* 某些内容的统计。写得太死，凡对应表单字段不可修改
**/
$for = isset($_GET['for'])? $_GET['for'] : '';
$time = isset($_GET['time'])? intval($_GET['time']) : '';
$this_module -> set_model('peixinbaoming');
if($for == 'teach'){
	foreach($this_model['fields']['peixunfangang']['data'] as $key => $val){
		$data['id'] = $key;
		$data['name'] = $val;
		$data['count'] = 0;
		$list[$key] = $data;
	} 
	
	$query = $this_module->core->DB_master->fetch_all("SELECT count(id) as c, id, peixunfangang,tbsj FROM $this_module->data_table WHERE pxlx ='3' group by yuangongxingming");
	foreach($query as $detail){
		$list[$detail['peixunfangang']]['count'] = $detail['c'];
		$list[$detail['peixunfangang']]['tbsj'] = $detail['tbsj'];
	}

	include template($this_module, 'mystatistics');
}elseif($for == 'studited'){
	foreach($this_model['fields']['peixunfangang']['data'] as $key => $val){
		$data['id'] = $key;
		$data['name'] = $val;
		$data['count'] = 0;
		$list[$key] = $data;
	} 
	
	$query = $this_module->core->DB_master->fetch_all("SELECT count(id) as c, id, peixunfangang,tbsj FROM $this_module->data_table WHERE pxlx ='4' group by laoshixingming");
	foreach($query as $detail){
		$list[$detail['peixunfangang']]['count'] = $detail['c'];
		$list[$detail['peixunfangang']]['tbsj'] = $detail['tbsj'];
	}

	include template($this_module, 'mystatistics');
}

