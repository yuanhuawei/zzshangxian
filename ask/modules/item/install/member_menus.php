<?php
return array(
	array(
		'name' => '�ҵ�����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 99,
		
		'menus' => array(
			array(
				'name' => '��Ҫ����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'ask',
				'target'=> '_blank',
				'front' => 1,
				'display_order' => 98
			),
			array(
				'name' => '�ҵ�����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_ask',
				'display_order' => 97
			),
			array(
				'name' => '�ҵ��ղ�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_favorite',
				'display_order' => 95
			),
			array(
				'name' => '�ҹ��������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'verify',
				'display_order' => 90
			)
		)
	)
);