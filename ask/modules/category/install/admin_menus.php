<?php
return array(
	array(
		'name' => '问答分类',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 97,
		
		'menus' => array(
			array(
				'name' => '分类添加',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'batch_add',
				'display_order' => 99
			),
			array(
				'name' => '分类列表',
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