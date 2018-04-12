<?php
defined('PHP168_PATH') or die();

/**
* 删除冗余附件,仅删除游客上传但没有提交到具体内容的附件
**/

$uploader = &$core->load_module('uploader');

//核心附件
$uploader->set('core');
$uploader->delete(array(
	'where' => "item_id = '0' AND uid = '0'"
));

/*
//1小时前
$uploader->delete(array(
	'where' => "item_id = '0' AND timestamp < ". (P8_TIME - 3600 ) ." '0'"
));
*/

//各系统的附件
foreach($core->systems as $sys => $v){
	if(!$v['installed']) continue;	//没安装的不理
	
	$uploader->set($sys);
	$uploader->delete(array(
		'where' => "item_id = '0' AND uid = '0'"
	));
}