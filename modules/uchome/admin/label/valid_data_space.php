<?php
defined('PHP168_PATH') or die();

/**
* ���ݹ���,��option�е�ѡ��浽���ݿ�,ͬʱҲ��SQL������
**/

//�Ƿ���sphinx��������
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;

//����
//$option['forums'] = empty($option['forums']) ? array() : filter_int($option['forums']);
//�û�ID
if(!empty($option['uids'])){
		$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
		$option['uids'] = filter_int(explode(',', $option['uids']));
		
}
$option['var_fields'] = array();

//��ʼ����select
$select = select();
$select->from($this_module->TABLE_ .$type, '*');

//��ָ��ID
if(empty($option['uids'])){
		
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
	if(!empty($option['usergroup'])){
			$option['usergroup'] = preg_replace('/[^0-9,]/', '', $option['usergroup']);
			$option['usergroup'] = filter_int(explode(',', $option['usergroup']));
			$select->in('usergroup', $option['usergroup']);
	}
	
	if(!empty($option['username'])){
			$option['username'] = filter_int(explode(',', $option['username']));
			$select->in('username', $option['username']);
	}
	//ͷ��
	if(isset($option['avatar'])){
		$select->in('avatar', $option['avatar']);
	}//�û�״̬
	if(isset($option['flag'])){
		$select->in('flag', $option['flag']);
	}
}else{
		//ָ��ID,�����ҳ,��ʹ��sphinx, ���򰴴���ID��˳����
		$select->in('uid', $option['uids']);

}

//����
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//ѡ��
