<?php
return array(
	array(
		'name' => '�ܲ�Ͷ��',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 55,
		'menus' => array(
			array(
				'name' => 'Ͷ�߹���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list'
			),
			array(
				'name' => '��ҪͶ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'post'
			)
		)
	)
);