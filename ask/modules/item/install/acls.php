<?php

return array(
	
	//����ԱȨ��
	$core->CONFIG['administrator_role'] => array(
		'admin_actions' => array(
			'list'   => true,		//'�����б�'
			'update' => true,		//'�����޸�'
			'delete' => true,		//'����ɾ��'		
			'audit'  => true,		//'�������',
			'recommend' => true,		//'�����Ƽ�',
			'closed' => true,		//'����ر�',
			'answer' => true,		//'���б�',
			'answer_delete' => true,		//'ɾ����',
			'answer_audit' => true,		//'��˴�',
			'answer_best' => true,		//'������Ѵ�',
			'answer_vote' => true,		//'�鿴ͶƱ',
			'answer_content' => true,		//'�鿴����',
			'item_against' => true,		//'����Ͷ��',
			'answer_against' => true		//'��Ͷ��'
		)
	),
	//��ͨ��ԱȨ��
	$core->CONFIG['member_role'] => array(
		'actions' => array(
			'list' => true,		//'�����б�',
			'view' => true,		//'�鿴',
			'post' => true,		//'�ύ����',
			'update' => true,		//'�޸�',
			'my_list' => true,		//'�ҵ��б�',
			'my_ask' => true,		//'�ҵ�����',
			'search' => true		//'����'
		)
	),
	//�ο�Ȩ��
	$core->CONFIG['guest_role'] => array(
		'actions' => array(
			'list' => true,		//'�����б�',
			'view' => true,		//'�鿴',
			'search' => true		//'����'
		)
	)
);