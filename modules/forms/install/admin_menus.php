<?php
return array(
	array(
		'name' => '���ܱ�',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'list',
		'display_order' => 96,
		'position' => 'plugin',
		'menus' => array(
			array(
				'name' => '���ݹ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99,
			),
					
			array(
				'name' => '������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'model',
				'display_order' => 66
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