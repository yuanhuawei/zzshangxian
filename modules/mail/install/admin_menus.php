<?php
return array(
	array(
		'name' => '邮件模块',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 89,
		'position' => 'plugin',
		
		'menus' => array(
			
			array(
				'name' => '模块设置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			
			array(
				'name' => '发邮件测试',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'test',
				'display_order' => 98
			)
		)
	)
);