<?php
return array(
	//忽略项
	'alias' => 'CMS内容模块',
	'class' => 'P8_CMS_Item',
	'controller_class' => 'P8_CMS_Item_Controller',
	
	'admin_actions' => array(
		'config' => '模块配置',
		//'verify_acl' => '分级审核',
		
		'add' => '添加',
		'verify' => '审核',
		'move' => '移动内容',
		'clone' => '签发内容',
		
		'list' => '列表',
		'update' => '修改',
		'delete' => '删除',
		'update' => '修改',
		
		'comment' => '评论管理',
		'verify_comment' => '审核评论',
		'delete_comment' => '删除评论',
		
		'list_to_html' => '列表页静态',
		'view_to_html' => '内容页静态',
		
		'attribute' => '设置内容属性',
		'attribute_acl' => '内容属性分配权限',
		
		'label' => '标签管理',
		
		'list_order' => '置顶/下沉 内容',
		
		'create_time' => '发布时间',
		
		'set_acl' => '分配权限',
		
		'mood' => '表情管理',
		
		'spider' => '采集入库',
		'tag' => 'Tag(标签)管理',
		
		'cluster_push' => '推送数据'
	),
	
	'actions' => array(
		'search' => '搜索',
		'list' => '查看列表',
		'view' => '查看内容',
		'comment' => '发表评论',
		'add' => '发表内容',
		'autoverify' => '自动审核',
		//'my_list' => '我的内容',
		
		'update' => '修改',
		'delete' => '删除',
		//'move' => '移动',
		'verify' => '审核',
		'attribute' => '设置内容属性',
		'create_time' => '发布时间',
	),
	
	//可以用于积分规则的action
	'credit_rule_actions' => array(
		'verify' => '审核通过',
		'delete' => '被删除'
	),
	//忽略项
	
);