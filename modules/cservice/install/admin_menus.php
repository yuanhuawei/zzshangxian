<?php
return array(
	array(
		'name' => '�ͷ�����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 92,
		'position' => 'plugin',
		
		'menus' => array(
		array(
				'name' => '�ͷ���������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			array(
				'name' => '�ͷ����Ĺ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 88
			)
		)
	)
);