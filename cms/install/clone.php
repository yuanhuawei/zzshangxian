<?php
defined('PHP168_PATH') or die();

/**
* ��¡ϵͳ
**/

$postfix = '2';
$new_name = $this_system->name . $postfix;
$new_path = PHP168_PATH . $new_name .'/';

//����ϵͳ�ű�
cp($this_system->path,									PHP168_PATH . $new_name .'/');

//����ϵͳ��̨ģ��
cp(TEMPLATE_PATH .'admin/'. $this_system->name .'/',	TEMPLATE_PATH .'admin/'. $new_name .'/');

//����Ĭ��ģ��
cp(TEMPLATE_PATH .'default/'. $this_system->name .'/',	TEMPLATE_PATH .'default/'. $new_name .'/');

//�������԰�
cp(LANGUAGE_PATH .'zh-cn/'. $this_system->name .'/',	LANGUAGE_PATH .'zh-cn/'. $new_name .'/');

//���Ƽƻ�����
cp(PHP168_PATH .'crontab/cms_category_cache.php',		PHP168_PATH .'crontab/'. $new_name .'_category_cache.php');
cp(PHP168_PATH .'crontab/cms_index_to_html.php',		PHP168_PATH .'crontab/'. $new_name .'_index_to_html.php');
cp(PHP168_PATH .'crontab/cms_item_partition.php',		PHP168_PATH .'crontab/'. $new_name .'_item_partition.php');


//ϵͳ
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


//����ģ��
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


//ģ��ģ��
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


//����ģ��
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


//�ƻ�����
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