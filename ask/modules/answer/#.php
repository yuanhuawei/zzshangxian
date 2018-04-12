<?php
return array(
	//忽略项
	'alias' => '答案模块',
	'class' => 'P8_Ask_answer',
	'controller_class' => 'P8_Ask_answer_Controller',
	
	'admin_actions' => array(
		'verify' => '审核',
		'edit' => '编辑',
		'poller' => '投诉',
		'delete' => '删除答案',
		'list'		=> '答案列表',
		'against'	=> '答案投诉'
	),
	
	'actions' => array(
		'post' => '回答',
		'post_follow' => '追问',
		'fen' => '评分',
		'vote' => '投票',
		'poller' => '投诉',
		'verify'  => '审核',
		'edit' => '修改',
		'delete' => '删除',
		'set_best_answer' => '最佳答案'
	)
	
);