<?php
return array(
	array(
		'name' => '�û�����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 97,
		'menus' => array(
			array(
				'name' => 'ģ������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99,
			),
			
			array(
				'name' => '��ӻ�Ա/����Ա',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 98,
				'menus' => array(
					array(
						'name' => '��ӻ�Ա',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'add',
						'display_order' => 99
					),
					array(
						'name' => '������ӻ�Ա',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'impory',
						'display_order' => 88
					)
				)
			),	
			array(
				'name' => '��Ա����',
				'system' => 'core',
				'module' => 'member',
				'action' => 'list',
				'display_order' => 88
			),
			array(
				'name' => '��Ա��ֵ����',
				'system' => 'core',
				'module' => 'member',
				'action' => 'recharge',
				'display_order' => 87,
				'menus' => array(
					array(
						'name' => '��Ա��ֵ��¼',
						'system' => 'core',
						'module' => 'member',
						'action' => 'recharge',
						'display_order' => 87
					),
					array(
						'name' => '��ֵ������',
						'system' => 'core',
						'module' => 'member',
						'action' => 'recharge_card',
						'display_order' => 86
					),
					array(
						'name' => '��Ա������¼',
						'system' => 'core',
						'module' => 'member',
						'action' => 'buy_role',
						'display_order' => 85
					)
				)	
			),
			array(
				'name' => '��ɫ/Ȩ������',
				'system' => 'core',
				'module' => 'role',
				'action' => 'list',
				'display_order' => 77,
				'menus' => array(
					array(
						'name' => '��ɫ�б�',
						'system' => 'core',
						'module' => 'role',
						'action' => 'list',
						'display_order' => 99
					),
					array(
						'name' => '��ӽ�ɫ',
						'system' => 'core',
						'module' => 'role',
						'action' => 'add',
						'display_order' => 88
					)
				)
			),
			
			array(
				'name' => '��ɫ�����',
				'system' => 'core',
				'module' => 'role',
				'action' => 'list_group',
				'display_order' => 66,
				'menus' => array(
					array(
						'name' => '��ɫ�����',
						'system' => 'core',
						'module' => 'role',
						'action' => 'list_group',
						'display_order' => 99
					),
					array(
						'name' => '��ӽ�ɫ��',
						'system' => 'core',
						'module' => 'role',
						'action' => 'add_group',
						'display_order' => 88
					)
				
				)
			)
		)
	)
);