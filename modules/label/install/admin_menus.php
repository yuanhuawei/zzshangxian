<?php
return array(
	array(
		'name' => '标签',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 93,
		'display' => S_version() == 'company' ? 0 : 1,
		'menus' => array(
			array(
				'name' => '添加标签',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			array(
				'name' => '标签列表',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 98
			),
			array(
				'name' => '更新缓存',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'cache',
				'display_order' => 97
			)
		)
	)
);