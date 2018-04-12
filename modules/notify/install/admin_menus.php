<?php
return array(
	array(
		'name' => '通知',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 86,
		'position' => 'extern',
		
		'menus' => array(
			
			array(
				'name' => '写通知',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			
			array(
				'name' => '通知管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 90
			),
			
			array(
				'name' => '模块配置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 80
			)
		)
	)
);