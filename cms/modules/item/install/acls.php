<?php
//Ĭ��Ȩ��,��ģ�鰲װ��ʱ�����

return array(
	//��ͨ��ԱȨ��
	$core->CONFIG['member_role'] => array(
		'admin_actions' => array(
		),
		
		'actions' => array(
			'list' => true,		//�����б�
			'view' => true,		//����鿴
			'add' => true,		//�������
			'delete' => true,	//����ɾ��
			'update' => true,	//�����޸�
			'my_list' => true,	//�����ҵ������б�
			'comment' => true,	//��������
			'search' => true,	//��������
		),
		
		//���Բ鿴���з��������
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
	
	//�ο�Ȩ��
	$core->CONFIG['guest_role'] => array(
		'admin_actions' => array(
		),
		
		'actions' => array(
			'list' => true,		//�����б�
			'view' => true,		//����鿴
			'comment' => true,	//��������
			'search' => true,	//��������
		),
		
		//���Բ鿴���з��������
		'category_acl' => array(
			0 => array(
				'actions' => array(
					'list' => true,
					'view' => true
				)
			)
		)
	),
	
	//����ԱȨ��
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
			'verify' => true,	//�������
			'move' => true,	//�����ƶ�
			'comment' => true,
			'verify_comment' => true,
			'delete_comment' => true,
		),
		
		'actions' => array(
			'list' => true,		//�����б�
			'view' => true,		//����鿴
			'add' => true,		//�������
			'update' => true,		//�����޸�
			'delete' => true,		//����ɾ��
			'verify' => true,		//�������
			'move' => true,		//�����ƶ�
			'my_list' => true,	//�����ҵ������б�
			'comment' => true,	//��������
			'search' => true,	//��������
			'autoverify' => true,//�Զ����
		),
		
		//���Բ鿴���з��������
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
	
	
	//���ԱȨ��
	$this_system->CONFIG['verifier_role'] => array(
		'admin_actions' => array(
			'add' => true,
			'list' => true,
			'update' => true,
			'verify' => true,	//�������
			'attribute' => true,
			'move' => true,	//�����ƶ�
			'comment' => true,
			'verify_comment' => true,
			'delete_comment' => true,
		),
		
		'actions' => array(
			'list' => true,		//�����б�
			'view' => true,		//����鿴
			'my_list' => true,	//�����ҵ������б�
			'add' => true,		//�������
			'update' => true,		//�����޸�
			'delete' => true,		//����ɾ��
			'verify' => true,		//�������
			'move' => true,		//�����ƶ�
			'mylist' => true,		//�ҷ�����
			'comment' => true,	//��������
			'search' => true,	//��������
			'autoverify' => true,//�Զ����
		),
		
		//���Բ鿴���з��������
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