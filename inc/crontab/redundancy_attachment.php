<?php
defined('PHP168_PATH') or die();

/**
* ɾ�����฽��,��ɾ���ο��ϴ���û���ύ���������ݵĸ���
**/

$uploader = &$core->load_module('uploader');

//���ĸ���
$uploader->set('core');
$uploader->delete(array(
	'where' => "item_id = '0' AND uid = '0'"
));

/*
//1Сʱǰ
$uploader->delete(array(
	'where' => "item_id = '0' AND timestamp < ". (P8_TIME - 3600 ) ." '0'"
));
*/

//��ϵͳ�ĸ���
foreach($core->systems as $sys => $v){
	if(!$v['installed']) continue;	//û��װ�Ĳ���
	
	$uploader->set($sys);
	$uploader->delete(array(
		'where' => "item_id = '0' AND uid = '0'"
	));
}