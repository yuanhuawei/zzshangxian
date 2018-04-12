<?php
//默认权限,由模块安装的时候调用

return array(
	
	$core->CONFIG['administrator_role'] => array(
		'admin_actions' => array(
			'config' => true,
			'list' => true,
			'label' => true,
			'category' => true
		)
	),
	
	//普通会员权限
	$core->CONFIG['member_role'] => array(
		
		'actions' => array(
			'view' => true,		//允许查看
			'post' => true  	//允许添加
		)
	),
	
	//游客权限
	$core->CONFIG['guest_role'] => array(
		'admin_actions' => array(
		),
		
		'actions' => array(
			'view' => true
		)
	)
);