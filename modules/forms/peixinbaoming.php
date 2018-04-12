<?php
defined('PHP168_PATH') or die();

/**
* 某些内容的统计。写得太死，凡对应表单字段不可修改
**/
$for = isset($_GET['for'])? $_GET['for'] : '';
$time = isset($_GET['time'])? intval($_GET['time']) : '';
$this_module -> set_model('peixinbaoming');
$list = $_list = array();
foreach($this_model['fields']['peixunfangang']['data'] as $key => $val){
		$data['id'] = $key;
		$data['name'] = $val;
		$data['count'] = 0;
		$_list[$key] = $data;
	} 
if($for == 'teach'){
	$query = $this_module->core->DB_master->fetch_all("SELECT count(id) as c, id, peixunfangang,tbsj FROM $this_module->data_table WHERE pxlx ='3' group by peixunfangang");
	foreach($query as $detail){
		$list[$detail['peixunfangang']]=$_list[$detail['peixunfangang']];
		unset($_list[$detail['peixunfangang']]);
		$list[$detail['peixunfangang']]['tbsj'] = $detail['tbsj'];
		$list[$detail['peixunfangang']]['count'] = $detail['c'];
		
	}
	$list = array_merge($list, $_list);
	include template($this_module, 'modeltemplade/peixinbaoming');
}elseif($for == 'studited'){
	$query = $this_module->core->DB_master->fetch_all("SELECT count(id) as c, id, peixunfangang,tbsj FROM $this_module->data_table WHERE pxlx ='4' group by peixunfangang");
	foreach($query as $detail){
		$list[$detail['peixunfangang']]=$_list[$detail['peixunfangang']];
		unset($_list[$detail['peixunfangang']]);
		$list[$detail['peixunfangang']]['tbsj'] = $detail['tbsj'];
		$list[$detail['peixunfangang']]['count'] = $detail['c'];
	}
	$list = array_merge($list,$_list);
	include template($this_module, 'modeltemplade/peixinbaoming');
}

