<?php
defined('PHP168_PATH') or die();

/**
* �б�ҳ
**/
$Letter = $core->load_module('letter');


$cate = $Letter->get_category();

$filter['department'] = empty($_POST['department'])?'': intval($_POST['department']);
$filter['begin_time'] = empty($_POST['begin_time'])?'': html_entities($_POST['begin_time']);
$filter['end_time'] = empty($_POST['end_time'])?'': html_entities($_POST['end_time']);
$total = $Letter->get_total($filter);

$alldata = $Letter->get_total(array());
$mon_total = $Letter->get_total(array('begin_time'=>'this month'));

//��������abs
$list_01 = $Letter->tonji_01();

//��������abs
$list_02 = $Letter->tonji_02();

//���abs
$list_03 = $Letter->tonji_03();

//�����abs
$list_04 = $Letter->tonji_04();

//ȫ�����
$list_05 = $Letter->tonji_05();

//ȫ���Ƶ�
$list_06 = $Letter->tonji_06();

//���ܺ��
$list_07 = $Letter->tonji_07();

//���ܻƵ�
$list_08 = $Letter->tonji_08();


//��ʼ����ǩ
$LABEL_POSTFIX = array();
//����������Լ��ı�ǩ��׺
array_push($LABEL_POSTFIX, 'redian');

include template($this_module, 'tongji');