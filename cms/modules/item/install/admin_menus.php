<?php
return array(
	array(
		'name' => '���ݹ���',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 96,
		
		'menus' => array(
			array(
				'name' => '��������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99,
			),
			array(
				'name' => '��������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 88,
				
				'menus' => array(
					array(
						'name' => '��������',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'list',
						'display_order' => 99
					),
					array(
						'name' => '���������',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'list?verified=0',
						'display_order' => 88
					),
					array(
						'name' => '���δͨ������',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'list?verified=-99',
						'display_order' => 77
					)
				)	
			),
			
			/* array(
				'name' => '�ּ����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'verify_acl',
				'display_order' => 66
			), */
			
			array(
				'name' => '����Ȩ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'attribute_acl',
				'display_order' => 65
			),
			
			array(
				'name' => '�ɼ����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'spider',
				'display_order' => 60
			),
			
			array(
				'name' => 'Tag(��ǩ)����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'tag',
				'display_order' => 59
			),
			
			array(
				'name' => 'ģ������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 55
			)
		)
	)
);