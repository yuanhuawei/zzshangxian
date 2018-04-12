<?php
defined('PHP168_PATH') or die();

/**
* 备份主键加速,确定你的主键字段是唯一的,并且仅能为数字类型
* 此文件下的表及字段描述可以大大提高备份速度,如果你对数据库不了解,不要乱加,否则会导致备份不全的后果
* 格式 表名 => 主键字段,
**/

//表前缀
$__T_ = $core->CONFIG['table_prefix'];

return array(
	
	$__T_ .'admin_log' => 'id',
	
	$__T_ .'member' => 'id',
	
	$__T_ .'cms_item' => 'id',
	
	//更多CMS模型自己写
	$__T_ .'cms_item_article_' => 'id',
	$__T_ .'cms_item_article_addon' => 'id',
	
	$__T_ .'cms_item_photo_' => 'id',
	$__T_ .'cms_item_photo_addon' => 'id',
	
	$__T_ .'cms_item_down_' => 'id',
	$__T_ .'cms_item_down_addon' => 'id',
	
	$__T_ .'cms_item_video_' => 'id',
	$__T_ .'cms_item_video_addon' => 'id',
	
	//更多表
	'1p8_cms_category' => 'id',
	'1p8_cms_item' => 'id',
	'1p8_cms_item_article_' => 'id',
	'1p8_cms_item_article_addon' => 'id',
	'f' => 'id',
);