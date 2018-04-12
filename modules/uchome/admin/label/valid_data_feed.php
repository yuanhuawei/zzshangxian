<?php
defined('PHP168_PATH') or die();

/**
* ���ݹ���,��option�е�ѡ��浽���ݿ�,ͬʱҲ��SQL������
**/

//�Ƿ���sphinx��������
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;

//����
//$option['forums'] = empty($option['forums']) ? array() : filter_int($option['forums']);
$option['uids'] = isset($option['uids']) ? $option['uids'] : '';

$option['var_fields'] = array();

//��ʼ����select
$select = select();
$select->from($this_module->TABLE_ .$type, '*');

//����
$str = $comma = '';
foreach($option['order_by'] as $field => $desc){
	if(!isset($order_bys[$field])) continue;
	
	$str .= $comma . $field .($desc == -1 ? '' : ($desc ? ' DESC' : ' ASC'));
	$comma = ',';
}

if($str){
	$select->order($str);
	$option['order_by_string'] = $str;
}

if($option['uids']){
	//�����,
	$option['uids'] = filter_int(explode(',', $option['uids']));
	
	$select->in('uid', $option['uids']);
}


//����
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//ѡ��
