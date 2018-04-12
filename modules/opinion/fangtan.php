<?php
defined('PHP168_PATH') or die();

/**
* 查看内容入口文件
**/
//$this_controller->check_action('list') or message('no_privilege');

$TITLE = $SEO_KEYWORDS = $SEO_DESCRIPTION = '';

$Interview = $core->load_module('interview');	
load_language($Interview,'global');
$select = select();
$select->from("{$Interview->table_subject} AS s", 's.*');
$select->order('s.id desc');
$select->limit('1');
//echo $select->build_sql();	
$subject = $core->select($select,array('single' => true));
$subject = attachment_url($subject);
$subject && $subject['url'] = $Interview->controller.'-view-'.$subject['id'];

$select = select();
$select->from("{$Interview->table_person} AS p", 'p.*');
$select->in('sid', $subject['id']);
$persons = $core->list_item($select);

//初始化标签
$LABEL_POSTFIX = array();
//如果分类有自己的标签后缀
array_push($LABEL_POSTFIX, 'fangtan');

include template($this_module, 'fangtan');
