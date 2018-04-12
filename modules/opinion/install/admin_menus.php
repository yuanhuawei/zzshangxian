<?php
return array(
	array(
		'name' => '意见征集',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'list',
		'display_order' => 90,
		'position' => 'plugin',
		'menus' => array(
			array(
				'name' => '模块设置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99,
			),
			array(
				'name' => '项目管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'item',
				'display_order' => 80,
			),
			array(
				'name' => '内容管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 55
			)
		)
	)
);