<?php
return array(
	array(
		'name' => '答案管理',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 95,
		
		'menus' => array(
			array(
				'name' => '答案列表',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99
			),
			array(
				'name' => '答案投诉',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'poller',
				'display_order' => 98
			)
		)
	),
);