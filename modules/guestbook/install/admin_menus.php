<?php
return array(
	array(
		'name' => '���Ա�',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 92,
		'position' => 'plugin',
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
				'name' => '���Ա�����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 95
			),array(
				'name' => '���Ա�����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'category',
				'display_order' => 90
			)
		)
	)
);