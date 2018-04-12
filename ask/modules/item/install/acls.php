<?php

return array(
	
	//管理员权限
	$core->CONFIG['administrator_role'] => array(
		'admin_actions' => array(
			'list'   => true,		//'问题列表'
			'update' => true,		//'问题修改'
			'delete' => true,		//'问题删除'		
			'audit'  => true,		//'问题审核',
			'recommend' => true,		//'问题推荐',
			'closed' => true,		//'问题关闭',
			'answer' => true,		//'答案列表',
			'answer_delete' => true,		//'删除答案',
			'answer_audit' => true,		//'审核答案',
			'answer_best' => true,		//'设置最佳答案',
			'answer_vote' => true,		//'查看投票',
			'answer_content' => true,		//'查看内容',
			'item_against' => true,		//'问题投诉',
			'answer_against' => true		//'答案投诉'
		)
	),
	//普通会员权限
	$core->CONFIG['member_role'] => array(
		'actions' => array(
			'list' => true,		//'问题列表',
			'view' => true,		//'查看',
			'post' => true,		//'提交问题',
			'update' => true,		//'修改',
			'my_list' => true,		//'我的列表',
			'my_ask' => true,		//'我的提问',
			'search' => true		//'搜索'
		)
	),
	//游客权限
	$core->CONFIG['guest_role'] => array(
		'actions' => array(
			'list' => true,		//'问题列表',
			'view' => true,		//'查看',
			'search' => true		//'搜索'
		)
	)
);