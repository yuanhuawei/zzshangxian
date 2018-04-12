<?php
//默认权限,由模块安装的时候调用

return array(
	//普通会员权限
	$core->CONFIG['member_role'] => array(
		'admin_actions' => array(
		),
		
		'actions' => array(
			'list' => true,		//允许列表
			'view' => true,		//允许查看
			'add' => true,		//允许添加
			'delete' => true,	//允许删除
			'update' => true,	//允许修改
			'my_list' => true,	//允许我的内容列表
			'comment' => true,	//允许评论
			'search' => true,	//允许搜索
		),
		
		//可以查看所有分类的内容
		'category_acl' => array(
			0 => array(
				'actions' => array(
					'list' => true,
					'add' => true,
					'view' => true
				)
			)
		),
		
		'my_addible_category' => array(
			0 => 0
		)
	),
	
	//游客权限
	$core->CONFIG['guest_role'] => array(
		'admin_actions' => array(
		),
		
		'actions' => array(
			'list' => true,		//允许列表
			'view' => true,		//允许查看
			'comment' => true,	//允许评论
			'search' => true,	//允许搜索
		),
		
		//可以查看所有分类的内容
		'category_acl' => array(
			0 => array(
				'actions' => array(
					'list' => true,
					'view' => true
				)
			)
		)
	),
	
	//管理员权限
	$core->CONFIG['administrator_role'] => array(
		'admin_actions' => array(
			'add' => true,
			'list' => true,
			'config' => true,
			'verify_acl' => true,
			'attribute' => true,
			'attribute_acl' => true,
			'list_order' => true,
			'list_to_html' => true,
			'view_to_html' => true,
			'spider' => true,
			'label' => true,
			'tag' => true,
			'update' => true,
			'delete' => true,
			'verify' => true,	//允许审核
			'move' => true,	//允许移动
			'comment' => true,
			'verify_comment' => true,
			'delete_comment' => true,
		),
		
		'actions' => array(
			'list' => true,		//允许列表
			'view' => true,		//允许查看
			'add' => true,		//允许添加
			'update' => true,		//允许修改
			'delete' => true,		//允许删除
			'verify' => true,		//允许审核
			'move' => true,		//允许移动
			'my_list' => true,	//允许我的内容列表
			'comment' => true,	//允许评论
			'search' => true,	//允许搜索
			'autoverify' => true,//自动审核
		),
		
		//可以查看所有分类的内容
		'category_acl' => array(
			0 => array(
				'actions' => array(
					'list' => true,
					'view' => true,
					'move' => true,
					'add' => true,
					'update' => true
				)
			)
		),
		
		'my_addible_category' => array(
			0 => 1
		)
	),
	
	
	//审稿员权限
	$this_system->CONFIG['verifier_role'] => array(
		'admin_actions' => array(
			'add' => true,
			'list' => true,
			'update' => true,
			'verify' => true,	//允许审核
			'attribute' => true,
			'move' => true,	//允许移动
			'comment' => true,
			'verify_comment' => true,
			'delete_comment' => true,
		),
		
		'actions' => array(
			'list' => true,		//允许列表
			'view' => true,		//允许查看
			'my_list' => true,	//允许我的内容列表
			'add' => true,		//允许添加
			'update' => true,		//允许修改
			'delete' => true,		//允许删除
			'verify' => true,		//允许审核
			'move' => true,		//允许移动
			'mylist' => true,		//我发布的
			'comment' => true,	//允许评论
			'search' => true,	//允许搜索
			'autoverify' => true,//自动审核
		),
		
		//可以查看所有分类的内容
		'category_acl' => array(
			0 => array(
				'actions' => array(
					'list' => true,
					'view' => true,
					'move' => true,
					'add' => true,
					'update' => true,
					'verify' => true
				)
			)
		),
		
		'my_addible_category' => array(
			0 => 1
		)
	)
);