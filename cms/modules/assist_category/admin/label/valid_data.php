<?php
defined('PHP168_PATH') or die();

/**
* ���ݹ���,��option�е�ѡ��浽���ݿ�,ͬʱҲ��SQL������
**/

//������
$system = isset($_POST['system']) ? $_POST['system'] : '';
$module = isset($_POST['module']) ? $_POST['module'] : '';


if($system != 'core' && !get_system($system)){
	message('no_such_system');
}

if($module && !get_module($system, $module)){
	message('no_such_module');
}

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
$option['var_fields'] = array();

//����
$option['category'] = empty($option['category']) ? array() : $option['category'];
if($option['category']){
	$option['category'] = preg_replace("/[^0-9,]/", '', $option['category']);
	//�����,
	$option['category'] = filter_int(explode(',', $option['category']));
}

//����
$str = $comma = '';
foreach($option['order_by'] as $field => $desc){
	$str .= $comma . $field .($desc ? ' DESC' : ' ASC');
	$comma = ',';
}

if($str){
	$option['order_by_string'] = $str;
}

