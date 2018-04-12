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

	//�û�ID
	if(!empty($option['uids'])){
			$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
			$option['uids'] = filter_int(explode(',', $option['uids']));
			$select->in('uid', $option['uids']);
	}
	
	//����ʱ��
	if(!empty($option['dateline'])){
		$select->range('dateline', P8_TIME-$option['dateline']);
	}
	//����ʱ��
	if(!empty($option['updatetime'])){
		$select->range('updatetime', P8_TIME-$option['updatetime']);
	}
	//��˽��Χ
	if(isset($option['friend'])){
		$select->in('friend', $option['friend']);
	}
	//Ⱥ��ID
	if(isset($option['tagid'])){
		$option['tagid'] = preg_replace('/[^0-9,]/', '', $option['tagid']);
		$option['tagid'] = filter_int(explode(',', $option['tagid']));
		$select->in('tagid', $option['tagid']);
	}
	
}else{
		//ָ��ID,�����ҳ,��ʹ��sphinx, ���򰴴���ID��˳����
		$select->in('threadid', $option['ids']);

}

//����
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//ѡ��
