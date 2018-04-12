<?php
return array(
	//忽略项
	'alias' => '会员模块',
	'class' => 'P8_Member',
	'controller_class' => 'P8_Member_Controller',
	
	'admin_actions' => array(
		'config' => '配置',
		'add' => '添加会员',
		'add_list' => '导入会员',
		'list' => '会员列表',
		'update' => '修改会员',
		'delete' => '删除会员',
		'batch_send' => '批量发送',
		'credit' => '修改积分',
		'recharge' => '充值管理',
		'buy_role' => '会员升级管理',
		'integrate' => '系统整合',
		'transition' => '会员转换导入',
        'label' => '标签管理'
	),
	
	'actions' => array(
		'address_list' => '通讯录'
	),
	
	//可以添加积分规则的action
	'credit_rule_actions' => array(
		'register' => '注册',
		'login' => '登录',
		'update' => '完善资料'
	),
	//忽略项
	
	//保护项
	'integration_types' => array(	//整合类型
		'uc' => 'Ucenter',
		'pw' => 'phpwind',
		'p8' => 'php168(未实现)'
	),
	//保护项
	
);