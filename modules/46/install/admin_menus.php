<?php
return array(
	array(
		'name' => '���',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 99,
		'position' => 'plugin',
		
		'menus' => array(
			array(
				'name' => '��ӹ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			
			array(
				'name' => '������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 90
			),
			
			array(
				'name' => 'Ͷ�Ź���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'buy_list',
				'display_order' => 80
			),
			
			array(
				'name' => '���»���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'cache',
				'display_order' => 70
			)
		)
	)
);