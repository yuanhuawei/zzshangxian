<?php
return array(
	array(
		'name' => '�������',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 96,
		
		'menus' => array(
			array(
				'name' => '�����б�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99
			),
			array(
				'name' => '����Ͷ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'poller',
				'display_order' => 98
			),
			array(
				'name' => 'ģ������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 97
			),	
			array(
				'name' => 'sphinx����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'sphinx',
				'display_order' => 96
			)
		)
	),
);