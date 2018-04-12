<?php
return array(
	array(
		'name' => '问题管理',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 96,
		
		'menus' => array(
			array(
				'name' => '问题列表',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99
			),
			array(
				'name' => '问题投诉',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'poller',
				'display_order' => 98
			),
			array(
				'name' => '模块配置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 97
			),	
			array(
				'name' => 'sphinx配置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'sphinx',
				'display_order' => 96
			)
		)
	),
);