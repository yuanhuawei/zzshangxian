<?php
return array(
	array(
		'name' => '�ҵĻش�',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 90,
		
		'menus' => array(
				array(
				'name' => '�ҵĻش�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_answered',
				'display_order' => 96
			),
			array(
				'name' => '�ҹ���Ĵ�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'verify',
				'display_order' => 90
			)
		)
	)
);