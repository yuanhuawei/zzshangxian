<?php
return array(
	array(
		'name' => 'ר��',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 88,
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
				'name' => '���ר��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 97
			),
			array(
				'name' => 'ר�����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 98
			),
			array(
				'name' => '��ӷ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add_category',
				'display_order' => 95
			),array(
				'name' => '�������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'category_list',
				'display_order' => 96
			)
		)
	)
);