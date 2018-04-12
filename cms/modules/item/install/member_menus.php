<?php
return array(
	array(
		'name' => '内容管理',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display' => 1,
		'menus' => array(
			array(
				'name' => '发布内容',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			array(
				'name' => '我发布的内容',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_list',
				'display_order' => 98
			),
			array(
				'name' => '我签核的内容',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'verify',
				'display_order' => 97
			),
			array(
				'name' => '我的内容收藏',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'favory',
				'display_order' => 96
			),
			array(
				'name' => '我的订单',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_order',
				'display_order' => 96
			)
		)
	)
);