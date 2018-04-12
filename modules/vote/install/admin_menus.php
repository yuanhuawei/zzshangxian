<?php
return array(
	array(
		'name' => '投票',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 90,
		//扩展模块
		'position' => 'plugin',
		
		'menus' => array(
			
			array(
				'name' => '投票管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 98
			),
			
			array(
				'name' => '添加投票',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 90
			),
			
			array(
				'name' => '更新缓存',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'cache',
				'display_order' => 80
			)
		)
	)
);