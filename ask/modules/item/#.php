<?php
return array(
	//忽略项
	'alias' => '问题模块',
	'class' => 'P8_Ask_item',
	'controller_class' => 'P8_Ask_item_Controller',
	
	'admin_actions' => array(
		'list'   => '问题列表',
		'update' => '问题修改',
		'delete' => '问题删除',		
		'verify'  => '问题审核',
		'recommend' => '问题推荐',
		'closed' => '问题关闭',
		'answer' => '答案列表',
		'answer_delete' => '删除答案',
		'answer_audit' => '审核答案',
		'answer_best' => '设置最佳答案',
		'answer_vote' => '查看投票',
		'answer_content' => '查看内容',
		'item_against' => '问题投诉',
		'answer_against' => '答案投诉',
		'config' => '模块配置',
		'set_acl' => '分配权限',
		'sphinx' => 'sphinx配置',
		'label' => '标签管理',
	),
	
	'actions' => array(
		'post' => '提交问题',
		'list' => '问题列表',
		'view' => '查看',
		'poller' => '投诉',
		'search' => '搜索',
		'verify'  => '审核',
		'edit' => '修改',
		'delete' => '删除'
	),
	
	//可以用于积分规则的action
	/*'credit_rule_actions' => array(
		'post' => '提交问题',
		'delete' => '被删除'
	),*/
	//忽略项
	
	/*
	//sphinx插件选项
	'sphinx' => array(
		'enabled' => true,	//是否启用
		'host' => 'localhost',	//主机
		'port' => 3312,	//端口
		'index' => 'test-test_item',	//主索引
	),
	
	'max_page' => 500,	//最大分页数
	*/
);