<?php
return array(
	array(
		'name' => '���ݹ���',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display' => 1,
		'menus' => array(
			array(
				'name' => '��������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			array(
				'name' => '�ҷ���������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_list',
				'display_order' => 98
			),
			array(
				'name' => '��ǩ�˵�����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'verify',
				'display_order' => 97
			),
			array(
				'name' => '�ҵ������ղ�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'favory',
				'display_order' => 96
			),
			array(
				'name' => '�ҵĶ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_order',
				'display_order' => 96
			)
		)
	)
);