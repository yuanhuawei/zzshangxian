<?php
return array(
	array(
		'name' => 'ͶƱ',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 90,
		//��չģ��
		'position' => 'plugin',
		
		'menus' => array(
			
			array(
				'name' => 'ͶƱ����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 98
			),
			
			array(
				'name' => '���ͶƱ',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 90
			),
			
			array(
				'name' => '���»���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'cache',
				'display_order' => 80
			)
		)
	)
);