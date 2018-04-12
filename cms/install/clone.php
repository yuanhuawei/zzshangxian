<?php
defined('PHP168_PATH') or die();

/**
* 克隆系统
**/

$postfix = '2';
$new_name = $this_system->name . $postfix;
$new_path = PHP168_PATH . $new_name .'/';

//复制系统脚本
cp($this_system->path,									PHP168_PATH . $new_name .'/');

//复制系统后台模板
cp(TEMPLATE_PATH .'admin/'. $this_system->name .'/',	TEMPLATE_PATH .'admin/'. $new_name .'/');

//复制默认模板
cp(TEMPLATE_PATH .'default/'. $this_system->name .'/',	TEMPLATE_PATH .'default/'. $new_name .'/');

//复制语言包
cp(LANGUAGE_PATH .'zh-cn/'. $this_system->name .'/',	LANGUAGE_PATH .'zh-cn/'. $new_name .'/');

//复制计划任务
cp(PHP168_PATH .'crontab/cms_category_cache.php',		PHP168_PATH .'crontab/'. $new_name .'_category_cache.php');
cp(PHP168_PATH .'crontab/cms_index_to_html.php',		PHP168_PATH .'crontab/'. $new_name .'_index_to_html.php');
cp(PHP168_PATH .'crontab/cms_item_partition.php',		PHP168_PATH .'crontab/'. $new_name .'_item_partition.php');


//系统
//------------------------------------------------------------------
$file = $new_path .'#.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS', 'P8_CMS'. $postfix, $tmp));

$file = $new_path .'system.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS', 'P8_CMS'. $postfix, $tmp));

$file = $new_path .'controller.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS', 'P8_CMS'. $postfix, $tmp));
//------------------------------------------------------------------


//内容模块
//------------------------------------------------------------------
$file = $new_path .'modules/item/#.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS_Item', 'P8_CMS_Item'. $postfix, $tmp));

$file = $new_path .'modules/item/module.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS_Item', 'P8_CMS_Item'. $postfix, $tmp));

$file = $new_path .'modules/item/controller.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS_Item', 'P8_CMS_Item'. $postfix, $tmp));
//------------------------------------------------------------------


//模型模块
//------------------------------------------------------------------
$file = $new_path .'modules/model/#.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS_Model', 'P8_CMS_Model'. $postfix, $tmp));

$file = $new_path .'modules/model/module.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS_Model', 'P8_CMS_Model'. $postfix, $tmp));

$file = $new_path .'modules/model/controller.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS_Model', 'P8_CMS_Model'. $postfix, $tmp));
//------------------------------------------------------------------


//分类模块
//------------------------------------------------------------------
$file = $new_path .'modules/category/#.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS_Category', 'P8_CMS_Category'. $postfix, $tmp));

$file = $new_path .'modules/category/module.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS_Category', 'P8_CMS_Category'. $postfix, $tmp));

$file = $new_path .'modules/category/controller.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('P8_CMS_Category', 'P8_CMS_Category'. $postfix, $tmp));
//------------------------------------------------------------------


//计划任务
//------------------------------------------------------------------
$file = PHP168_PATH .'crontab/'. $new_name .'_category_cache.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('cms', 'cms'. $postfix, $tmp));
//------------------------------------------------------------------


//------------------------------------------------------------------
$file = PHP168_PATH .'crontab/'. $new_name .'_index_to_html.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('cms', 'cms'. $postfix, $tmp));
//------------------------------------------------------------------


//------------------------------------------------------------------
$file = PHP168_PATH .'crontab/'. $new_name .'_item_partition.php';
$tmp = file_get_contents($file);
write_file($file, str_replace('cms', 'cms'. $postfix, $tmp));
//------------------------------------------------------------------