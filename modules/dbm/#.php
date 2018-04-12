<?php
return array(
	//忽略项
	'alias' => '数据库管理',
	'class' => 'P8_DBM',
	'controller_class' => 'P8_DBM_Controller',
	
	'admin_actions' => array(
		'' => '管理'
	),
	
	'actions' => array(
	),
	
	'table_alias' => array(
		
		'system' => '系统',
		'module' => '模块',
		'plugin' => '插件',
		'member' => '会员',
		'config' => '配置表',
		'session' => '会话表(用户登录)',
		'acl' => '权限表',
		
		'admin_log' => '后台日志',
		'admin_menu' => '后台菜单',
		'member_menu' => '会员中心菜单',
		
		'credit' => '积分',
		'credit_member' => '会员积分',
		'credit_rule' => '积分规则',
		'credit_rule_log' => '积分规则日志',
		'credit_rule_log_cache' => '积分规则日志缓存',
		'acl' => '权限表',
		'label' => '标签',
		'role' => '角色',
		'role_group' => '角色组',
		'role_group_field' => '角色组字段',
		'sphinx' => 'sphinx 计数表',
		'crontab_' => '计划任务',
		
		'spider_category' => '采集规则分类',
		'spider_rule' => '采集规则',
		'spider_item' => '采集内容',
		'spider_item_addon' => '采集内容分页追加',
		
		'vote_' => '投票',
		'vote_option' => '投票选项',
		'vote_voter' => '投票者记录',
		
		'46_' => '广告',
		'46_buy' => '广告投放',
		'46_click_log' => '广告点击记录',
		
		'cms_item' => 'CMS内容主表',
		'cms_model' => 'CMS模型表',
		'cms_model_field' => 'CMS模型字段表',
		
		'cms_item_article_' => 'CMS文章模型',
		'cms_item_article_addon' => 'CMS文章模型追加表',
	)
	//忽略项
	
);