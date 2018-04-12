<?php
return array(
	array(
		'name' => '栏目管理',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 97,
		
		'menus' => array(
			array(
				'name' => '添加栏目',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			array(
				'name' => '栏目管理',
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