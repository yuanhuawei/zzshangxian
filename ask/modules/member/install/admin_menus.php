<?php
return array(
	array(
		'name' => '用户管理',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 98,
		
		'menus' => array(
			array(
				'name' => '用户列表',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99
			),
			array(
				'name' => '专家用户',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'expertor',
				'display_order' => 98
			),
			array(
				'name' => '问答之星',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'star',
				'display_order' => 97
			)
		)
	),

);