<?php
//Ĭ��Ȩ��,��ģ�鰲װ��ʱ�����

return array(
	
	$core->CONFIG['administrator_role'] => array(
		'admin_actions' => array(
			'config' => true,
			'list' => true,
			'label' => true,
			'category' => true
		)
	),
	
	//��ͨ��ԱȨ��
	$core->CONFIG['member_role'] => array(
		
		'actions' => array(
			'view' => true,		//����鿴
			'post' => true  	//�������
		)
	),
	
	//�ο�Ȩ��
	$core->CONFIG['guest_role'] => array(
		'admin_actions' => array(
		),
		
		'actions' => array(
			'view' => true
		)
	)
);