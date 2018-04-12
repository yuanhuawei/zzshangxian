<?php
return array(
	array(
		'name' => '我的问问',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 99,
		
		'menus' => array(
			array(
				'name' => '我要提问',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'ask',
				'target'=> '_blank',
				'front' => 1,
				'display_order' => 98
			),
			array(
				'name' => '我的提问',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_ask',
				'display_order' => 97
			),
			array(
				'name' => '我的收藏',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_favorite',
				'display_order' => 95
			),
			array(
				'name' => '我管理的问题',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'verify',
				'display_order' => 90
			)
		)
	)
);