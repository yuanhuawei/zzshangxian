<?php
return array(
	array(
		'name' => '独立页',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 92,
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
				'name' => '独立页管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => '88',
				'menus' => array(
					array(
						'name' => '管理独立页',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'list',
						'display_order' => 99
					),
					array(
						'name' => '新建独立页',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'add',
						'display_order' => 88
					)
				)
			)
		)
	)
);