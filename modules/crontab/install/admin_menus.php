<?php
return array(
	array(
		'name' => '�ƻ�����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 95,
		'display' => S_version() == 'company' ? 0 : 1,
		'menus' => array(
			array(
				'name' => '�ƻ������б�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99
			),
			array(
				'name' => '��Ӽƻ�����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 98
			)
		)
	)
);