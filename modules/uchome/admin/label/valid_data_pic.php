<?php
defined('PHP168_PATH') or die();

/**
* ���ݹ���,��option�е�ѡ��浽���ݿ�,ͬʱҲ��SQL������
**/

//�Ƿ���sphinx��������
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;

//����
//$option['forums'] = empty($option['forums']) ? array() : filter_int($option['forums']);
$option['ids'] = isset($option['ids']) ? $option['ids'] : '';
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
		$select->in('username', $option['username']);
	}

	if(!empty($option['albumid'])){
		$option['albumid'] = preg_replace('/[^0-9,]/', '', $option['albumid']);
		$option['albumid'] = filter_int(explode(',', $option['albumid']));
		$select->in('albumid', $option['albumid']);
	}
	//�û�ID
	if(!empty($option['uids'])){
			$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
			$option['uids'] = filter_int(explode(',', $option['uids']));
			$select->in('uid', $option['uids']);
	}

}else{
		
	//ָ����ID����������ᱻ����
	
	$option['ids'] = filter_int(explode(',', $option['ids']));
	$select->in('picid', $option['ids']);
}

//����
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//ѡ��
