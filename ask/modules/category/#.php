<?php
return array(
	//忽略项
	'alias' => '问答分类模块',
	'class' => 'P8_Ask_Category',
	'controller_class' => 'P8_Ask_Category_Controller',
	
	'admin_actions' => array(
		'insert' => '分类添加',
		'list' => '分类列表',
		'update' => '分类修改',
		'delete' => '分类删除',
		'set_acl' => '分配权限',
		'cache' => '更新缓存'
	),
	
	'actions' => array(
		'main' => '所有分类',
		'get' => 'Ajax获取分类'
	)
	//忽略项
	
	
);