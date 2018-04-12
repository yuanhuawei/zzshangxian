<?php
defined('PHP168_PATH') or die();

/**
* ���ݹ���,��option�е�ѡ��浽���ݿ�,ͬʱҲ��SQL������
**/

if($action == 'explain'){
	$_POST = p8_stripslashes2(from_utf8($_POST));
}

//������
$system = isset($_POST['system']) ? $_POST['system'] : '';
$module = isset($_POST['module']) ? $_POST['module'] : '';

$MODEL = empty($MODEL) ? '' : $MODEL;


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

//��ǰģ��
$option['model'] = $MODEL;



//�Ƿ���sphinx��������
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;


$option['fields'] = isset($option['fields']) && is_array($option['fields']) ? $option['fields'] : array();

//��ʼ����select
$select = select();
	
$select->from($this_module->table .' AS i', 'i.*');
$select->inner_join($this_module->data_table .' AS a', 'a.*', 'a.id = i.id');
if($option['status'] !=''){
	$select->in('i.status',$option['status']);
 }else{
	unset($option['status']);
 }
if($option['recommend'] >=0){
	$select->in('i.recommend',$option['recommend']); 
}	
//����
$str = $comma = '';
foreach($option['order_by'] as $field => $desc){
	if(!isset($order_bys[$field])) continue;
	
	$str .= $comma . $field .($desc ? ' DESC' : ' ASC');
	$comma = ',';
}

if($str){
	$select->order($str);
	$option['order_by_string'] = $str;
}


//����
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//ѡ��