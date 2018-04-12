<?php
return array(
	array(
		'name' => '手机短信',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 86,
		'position' => 'plugin',
		
		'menus' => array(
			
			array(
				'name' => '手机接口',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list_interface',
				'display_order' => 99
			),
			
			array(
				'name' => '接口测试',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'test',
				'display_order' => 98
			)
		)
	)
);