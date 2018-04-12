<?php
return array(
	//忽略项
	'alias' => '问答系统',
	'class' => 'P8_Ask',
	'controller_class' => 'P8_Ask_Controller',
	
	//后台操作
	'admin_actions' => array(
		'statistics' =>	'统计信息',
		'config' => '模块配置',
		'set_acl' => '分配权限',
		'cache_all'	=>	'更新缓存'
	),
	//前台操作
	'actions' => array(

	),

	'credit_rule_actions' => array(
		'enter' => '进入问答系统'
	),
	//忽略项
	
	//'bind_domain' => 'http://test.16865.com',	//绑定域名
);