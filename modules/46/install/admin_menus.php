<?php
return array(
	array(
		'name' => '广告',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 99,
		'position' => 'plugin',
		
		'menus' => array(
			array(
				'name' => '添加广告',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			
			array(
				'name' => '广告管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 90
			),
			
			array(
				'name' => '投放管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'buy_list',
				'display_order' => 80
			),
			
			array(
				'name' => '更新缓存',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'cache',
				'display_order' => 70
			)
		)
	)
);