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
$option['thread_type'] = isset($option['thread_type']) ? array_map('intval', $option['thread_type']) : array(0);
$option['digest'] = isset($option['digest']) ? filter_int($option['digest'], true) : array();
$option['keyword'] = isset($option['keyword']) ? $option['keyword'] : '';
$option['var_fields'] = array();

//��ʼ����select
$select = select();
$select->from($this_module->TABLE_ .$type, '*');

//��ָ��ID
if(empty($option['ids'])){
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
	
	if($option['username']){
		$option['username'] = explode(',', $option['username']);
		$select->in('username', $option['forums']);
	}
	//����ʱ��
	if(!empty($option['dateline'])){
			$select->range('dateline', P8_TIME-$option['dateline']);
		}
	//�û�ID
	if(!empty($option['uids'])){
			$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
			$option['uids'] = filter_int(explode(',', $option['uids']));
	}
	
	//�����ؼ���
	if(!empty($option['subject'])){
		$select->search('subject', $option['subject']);
	}
		
}else{
	
	//ָ����ID����������ᱻ����
	
	$option['ids'] = filter_int(explode(',', $option['ids']));
	$select->in('id', $option['ids']);
}

//����
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//ѡ��
