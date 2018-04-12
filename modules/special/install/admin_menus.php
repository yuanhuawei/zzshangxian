<?php
return array(
	array(
		'name' => '专题',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 88,
		'position' => 'plugin',
		
		'menus' => array(
			array(
				'name' => '模块配置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			array(
				'name' => '添加专题',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 97
			),
			array(
				'name' => '专题管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 98
			),
			array(
				'name' => '添加分类',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add_category',
				'display_order' => 95
			),array(
				'name' => '分类管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'category_list',
				'display_order' => 96
			)
		)
	)
);