<?php
return array(
	array(
		'name' => '����Ŀ����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 80,
		
		'menus' => array(
			array(
				'name' => '��Ӹ���Ŀ',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			array(
				'name' => '����Ŀ����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 88
			),
			array(
				'name' => '����Ŀ���ݹ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'content_list',
				'display_order' => 77
			)
		)
	)
);