<?php
return array(
	array(
		'name' => '�ʼ�ģ��',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 89,
		'position' => 'plugin',
		
		'menus' => array(
			
			array(
				'name' => 'ģ������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			
			array(
				'name' => '���ʼ�����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'test',
				'display_order' => 98
			)
		)
	)
);