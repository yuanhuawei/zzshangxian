<?php
return array(
	array(
		'name' => '֪ͨ',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 86,
		'position' => 'extern',
		
		'menus' => array(
			
			array(
				'name' => 'д֪ͨ',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			
			array(
				'name' => '֪ͨ����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 90
			),
			
			array(
				'name' => 'ģ������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 80
			)
		)
	)
);