<?php
return array(
	array(
		'name' => '�𰸹���',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 95,
		
		'menus' => array(
			array(
				'name' => '���б�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99
			),
			array(
				'name' => '��Ͷ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'poller',
				'display_order' => 98
			)
		)
	),
);