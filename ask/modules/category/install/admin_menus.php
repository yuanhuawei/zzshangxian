<?php
return array(
	array(
		'name' => '�ʴ����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 97,
		
		'menus' => array(
			array(
				'name' => '�������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'batch_add',
				'display_order' => 99
			),
			array(
				'name' => '�����б�',
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