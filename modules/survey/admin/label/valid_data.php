<?php
defined('PHP168_PATH') or die();

/**
* ���ݹ���,��option�е�ѡ��浽���ݿ�,ͬʱҲ��SQL������
**/

if($action == 'explain'){
	$_POST = p8_stripslashes2(from_utf8($_POST));
}
//��ʼ����select
$select = select();
//����Դģ����Ϣ
$_POST['source_system'] = $this_system->name;
$_POST['source_module'] = $this_module->name;
//��ǩ����Ϊģ������
$_POST['type'] = 'module_data';

$controller = &$core->controller($LABEL);

$option = isset($_POST['option']) && is_array($_POST['option']) ? $_POST['option'] : array();


//��ǩͨ�ò���,����֤�õ����ݸ���ԭ��������
$option = $controller->valid_module_data_option($option) + $option;
unset($option['order_by_desc']);

$select->from($this_module->table .' AS i', 'i.*');
	$lenght = intval($option['summary_length']);
	
	
//����
$str = $comma = '';
foreach($option['order_by'] as $field => $desc){
	$str .= $comma . $field .($desc ? ' DESC' : ' ASC');
	$comma = ',';
}

if($str){
	$select->order($str);
	$option['order_by_string'] = $str;
}

$option['var_fields'] = array();
if(!empty($option['ids'])){
	$option['ids'] = filter_int(explode(',', $option['ids']));
	$select->in('i.id', $option['ids']);
}else{
$select->in('i.status', 1);
		if(!empty($option['status'])){
			if($option['status']==1)
				$select->range('i.endtime', P8_TIME);
			if($option['status']==2)
				$select->range('i.endtime', '',P8_TIME);
		}

}
$_POST['option'] = $option;		//ѡ��