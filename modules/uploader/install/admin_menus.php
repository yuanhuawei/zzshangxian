<?php
return array(
	array(
		'name' => '�ϴ�ģ��',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 94,
		'display' => S_version() == 'company' ? 0 : 1,
		'menus' => array(
			array(
				'name' => 'ģ������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			array(
				'name' => '��������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 98
			),
			array(
				'name' => '�ϴ�Ȩ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'role_filter',
				'display_order' => 97
			)
			
		)
	)
);