<?php
return array(
	array(
		'name' => '�ҵ�����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'profile',
		'display_order' => 99,
		
		'menus' => array(
			/* array(
				'name' => '���ѹ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'friend',
				'display' => 1,
				'display_order' => 88
			),
			array(
				'name' => '���ѷ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'friend_category',
				'display' => 1,
				'display_order' => 77
			),
			array(
				'name' => 'ͨѶ¼',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'address_list',
				'target' => '_blank',
				'display' => 0,
				'display_order' => 70
			), */
			array(
				'name' => '�޸Ļ�����Ϣ',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'profile',
				'display_order' => 66
			)/* ,
			array(
				'name' => '��Ա����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'buy_role',
				'front' => 1,
				'display' => 1,
				'target' => '_blank',
				'display_order' => 55
			) */
		)
	),
	
	array(
		'name' => '֧��',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display' => 0,
		'display_order' => 97,
		
		'menus' => array(
			array(
				'name' => '��ֵ',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'recharge',
				'front' => 1,
				'target' => '_blank',
				'display_order' => 99
			),
			array(
				'name' => '��ֵ��¼',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'recharge_log',
				'display_order' => 97
			)
		)
	)
);