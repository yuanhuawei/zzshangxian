<?php
defined('PHP168_PATH') or die();

/**
* 列表页
**/
$Letter = $core->load_module('letter');


$cate = $Letter->get_category();

$filter['department'] = empty($_POST['department'])?'': intval($_POST['department']);
$filter['begin_time'] = empty($_POST['begin_time'])?'': html_entities($_POST['begin_time']);
$filter['end_time'] = empty($_POST['end_time'])?'': html_entities($_POST['end_time']);
$total = $Letter->get_total($filter);

$alldata = $Letter->get_total(array());
$mon_total = $Letter->get_total(array('begin_time'=>'this month'));

//来信总数abs
$list_01 = $Letter->tonji_01();

//受理总数abs
$list_02 = $Letter->tonji_02();

//办结abs
$list_03 = $Letter->tonji_03();

//办结率abs
$list_04 = $Letter->tonji_04();

//全部红灯
$list_05 = $Letter->tonji_05();

//全部黄灯
$list_06 = $Letter->tonji_06();

//本周红灯
$list_07 = $Letter->tonji_07();

//本周黄灯
$list_08 = $Letter->tonji_08();


//初始化标签
$LABEL_POSTFIX = array();
//如果分类有自己的标签后缀
array_push($LABEL_POSTFIX, 'redian');

include template($this_module, 'tongji');