<?php
return array(
	//忽略项
	'alias' => '投票',
	'class' => 'P8_Vote',
	'controller_class' => 'P8_Vote_Controller',
	
	'admin_actions' => array(
		'vote' => '投票管理',
		'truncate' => '清空结果',
		'delete' => '删除投票',
        'label' => '标签管理'
	),
	
	'actions' => array(
		'view_result' => '查看投票结果',
		'voter' => '查看投票人'
	),
	
	'credit_rule_actions' => array(
		'vote' => '参与投票'
	)
	//忽略项
	
);