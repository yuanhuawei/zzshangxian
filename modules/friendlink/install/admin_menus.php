<?php
return array(
	array(
		'name' => '��������',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 78,
		'position' => 'plugin',
		
		'menus' => array(
			array(
				'name' => '�������ӹ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'link',
				'display_order' => 99
			),
			array(
				'name' => '�������ӷ������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'sort',
				'display_order' => 98
			)
		)
	)
);