<?php
defined('PHP168_PATH') or die();

/**
* 查看内容入口文件
**/
//$this_controller->check_action('list') or message('no_privilege');
$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
$TITLE = $core->CONFIG['site_name'];

//初始化标签
$LABEL_POSTFIX = array();
//如果分类有自己的标签后缀
array_push($LABEL_POSTFIX, 'weibo');

include template($this_module, 'weibo');
