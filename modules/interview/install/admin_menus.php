<?php
return array(
	array(
		'name' => '���߷�̸',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 0,
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
				'name' => '��̸����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list_subject',
				'display_order' => 99
			),array(
				'name' => '��ӷ�̸',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add_subject',
				'display_order' => 98
			)
		)
	)
);