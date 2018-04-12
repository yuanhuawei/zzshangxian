<?php
return array(
	array(
		'name' => '领导信箱',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 92,
		'position' => 'plugin',
		'menus' => array(
		array(
				'name' => '领导信箱设置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			array(
				'name' => '领导信箱管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 88
			),
			array(
				'name' => '领导信箱统计',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistics',
				'display_order' => 87
			)
		)
	)
);