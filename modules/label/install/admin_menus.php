<?php
return array(
	array(
		'name' => '��ǩ',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 93,
		'display' => S_version() == 'company' ? 0 : 1,
		'menus' => array(
			array(
				'name' => '��ӱ�ǩ',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			array(
				'name' => '��ǩ�б�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 98
			),
			array(
				'name' => '���»���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'cache',
				'display_order' => 97
			)
		)
	)
);