<?php
return array(
	array(
		'name' => '���',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 88,
		'position' => '',
		'display' => 0,
		'menus' => array(
			array(
				'name' => '�鿴���λ',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99
			),
			
			array(
				'name' => '��Ͷ�Ź��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'mime',
				'display_order' => 98
			)
		)
	)
);