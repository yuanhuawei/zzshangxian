<?php
return array(
	array(
		'name' => 'ģ�͹���',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'manage',
		'display_order' => 70,
		
		'menus' => array(
			array(
				'name' => '���ģ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			array(
				'name' => '����ģ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'import',
				'display_order' => 97
			),
			array(
				'name' => 'ģ���б�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 96
			)
		)
	)
);