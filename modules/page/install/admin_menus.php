<?php
return array(
	array(
		'name' => '����ҳ',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 92,
		'position' => 'plugin',
		
		'menus' => array(
			array(
				'name' => 'ģ������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			array(
				'name' => '����ҳ����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => '88',
				'menus' => array(
					array(
						'name' => '�������ҳ',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'list',
						'display_order' => 99
					),
					array(
						'name' => '�½�����ҳ',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'add',
						'display_order' => 88
					)
				)
			)
		)
	)
);