<?php
defined('PHP168_PATH') or die();

/**
* 列表页
**/
$Letter = $core->load_module('letter');

$i = empty($_GET['i'])? '' : intval($_GET['i']);
$cate = $Letter->get_category();

$mehtod = 'tonji_'.str_pad($i,2,'0',STR_PAD_LEFT);

if(!method_exists($Letter, $mehtod))message('no_privilege');

$page = isset($_GET['page'])? intval($_GET['page']): 1;

//$list_info = $Letter->$mehtod(array('pagesize'=>1,'page'=>$page,'page_url'=>$this_url.'?i='.$i));
$list_info = $Letter->$mehtod(array('pagesize'=>0,'page'=>0,'page_url'=>$this_url.'?i='.$i));

$list = $list_info['list'];
$pages = $list_info['pages'];

//初始化标签
$LABEL_POSTFIX = array();
//如果分类有自己的标签后缀
array_push($LABEL_POSTFIX, 'redian');

include template($this_module, 'tjgd');