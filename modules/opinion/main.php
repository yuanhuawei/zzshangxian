<?php
defined('PHP168_PATH') or die();

/**
* �鿴��������ļ�
**/

$Letter = $core->load_module('letter');
//��������abs
$list_01 = $Letter->tonji_01(array('pagesize'=>100));

//��������abs
$list_02 = $Letter->tonji_02(array('pagesize'=>100));

//���abs
$list_03 = $Letter->tonji_03(array('pagesize'=>100));

//�����abs
$list_04 = $Letter->tonji_04(array('pagesize'=>100));

//��Ƶ�
$list_09 = $Letter->tonji_09(array('pagesize'=>100));
$cate = $Letter->get_category();
$filter['department'] = '';
$filter['begin_time'] = 'today';
$filter['end_time'] = '';
$total = $Letter->get_total($filter);

/*this year*/
$Y = date('Y');
$filter_2015['department'] = '';
$filter_2015['begin_time'] = $Y.'-01-01 00:00:00';
$filter_2015['end_time'] = '';
$total_this_year = $Letter->get_total($filter_2015);

/*all*/
$filter_all['department'] = '';
$filter_all['begin_time'] = '';
$filter_all['end_time'] = '';
$total_all = $Letter->get_total($filter_all);

$today  = $Letter->get_total(array('begin_time'=>'today'));
$mon_total = $Letter->get_total(array('begin_time'=>'this month'));
$all  = $Letter->get_total();
$cates = $Letter->get_category();

$TITLE = $SEO_KEYWORDS = $SEO_DESCRIPTION = '';

//��ʼ����ǩ
$LABEL_POSTFIX = array();
//����������Լ��ı�ǩ��׺
array_push($LABEL_POSTFIX, 'opinion');

include template($this_module, 'main');
