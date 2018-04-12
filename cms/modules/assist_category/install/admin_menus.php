<?php
return array(
	array(
		'name' => '副栏目管理',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 80,
		
		'menus' => array(
			array(
				'name' => '添加副栏目',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			array(
				'name' => '副栏目管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 88
			),
			array(
				'name' => '副栏目内容管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'content_list',
				'display_order' => 77
			)
		)
	)
);