<?php
return array(
	array(
		'name' => '�ֻ�����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 86,
		'position' => 'plugin',
		
		'menus' => array(
			
			array(
				'name' => '�ֻ��ӿ�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list_interface',
				'display_order' => 99
			),
			
			array(
				'name' => '�ӿڲ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'test',
				'display_order' => 98
			)
		)
	)
);