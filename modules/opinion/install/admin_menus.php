<?php
return array(
	array(
		'name' => '�������',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'list',
		'display_order' => 90,
		'position' => 'plugin',
		'menus' => array(
			array(
				'name' => 'ģ������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99,
			),
			array(
				'name' => '��Ŀ����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'item',
				'display_order' => 80,
			),
			array(
				'name' => '���ݹ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 55
			)
		)
	)
);