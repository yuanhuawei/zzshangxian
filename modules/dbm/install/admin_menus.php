<?php
return array(
	array(
		'name' => '���ݿ�',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 91,
	
		
		'menus' => array(
			array(
				'name' => '���ݿⱸ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'manage',
				'display_order' => 99
			),
			array(
				'name' => '���ݿ⻹ԭ',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'restore',
				'display_order' => 99
			)
		)
	)
);